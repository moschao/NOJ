<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Eloquent\Submission;
use App\Models\ContestModel as OutdatedContestModel;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    public function info(Request $request) {
        $contest = $request->contest;
        return response()->json([
            'success' => true,
            'message' => 'Succeed',
            'ret' => [
                "cid" => $contest->cid,
                "name" => $contest->name,
                "img" => url($contest->img),
                "begin_time" => $contest->begin_time,
                "end_time" => $contest->end_time,
                "problems" => count($contest->problems),
                "organizer" => $contest->group->name,
                "description" => $contest->description,
                "badges" => [
                    "rule_parsed" => ["Unknown", "ICPC", "IOI", "Custom ICPC", "Custom IOI"][$contest->rule],
                    "audit_status" => $contest->audit_status ? true : false,
                    "public" => $contest->public ? true : false,
                    "verified" => $contest->verified ? true : false,
                    "rated" => $contest->rated ? true : false,
                    "anticheated" => $contest->anticheated ? true : false,
                    "desktop" => $contest->desktop ? true : false,
                ]
            ],
            'err' => []
        ]);
    }

    public function status(Request $request) {
        $page = $request->page ?? 1;
        $filter = $request->filter;
        $contest = $request->contest;

        $account = $filter['account'] ?? null;
        $problem = $filter['problem'] ?? null;
        $result = $filter['result'] ?? null;

        //filter
        $builder = $contest->submissions()->orderBy('submission_date', 'desc')->with(['user', 'contest.group']);
        if($account !== null) {
            $participants = $contest->participants();
            $user = null;
            foreach($participants as $participant) {
                if($participant->name == $account){
                    $user = $participant;
                    break;
                }
            }
            $builder = $builder->where('uid', $user == null ? -1 : $user->id);
        }
        if($problem !== null){
            $problem = $contest->problems()->where('ncode', $problem)->first();
            $builder = $builder->where('pid', $problem->pid ?? null);
        }
        if($result !== null) {
            $builder = $builder->where('verdict', $result);
        }

        //status_visibility
        if($contest->status_visibility == 1){
            if(auth()->check()){
                $builder = $builder->where('uid', auth()->user()->id);
            }else{
                $builder = $builder->where('uid', -1);
            }
        }
        if($contest->status_visibility == 0){
            $builder = $builder->where('uid', -1);
        }

        $submissions = $builder->paginate(50);

        $regex = '/\?page=([\d+])$/';
        $matches = [];
        $pagination = [
            'current_page' => $submissions->currentPage(),
            'has_next_page' => $submissions->nextPageUrl() === null ? false : true,
            'has_previous_page' => $submissions->previousPageUrl() === null ? false : true,
            'next_page' => null,
            'previous_page' => null,
            'num_pages' => $submissions->lastPage(),
            'num_items' => $submissions->count(),
        ];
        if($pagination['has_next_page']) {
            $next_page = preg_match($regex, $submissions->nextPageUrl(), $matches);
            $pagination['next_page'] = intval($matches[1]);
        }
        if($pagination['has_previous_page']) {
            $next_page = preg_match($regex, $submissions->previousPageUrl(), $matches);
            $pagination['previous_page'] = intval($matches[1]);
        }

        $data = [];
        foreach($submissions->items() as $submission) {
            $score_parse = 0;
            if($contest->rule == 2){
                if($submission->verdict == 'Accepted') {
                    $score_parse = 100;
                }else if($submission->verdict == 'Partially Accepted') {
                    $score_parse = round($submission->score / $submission->problem->tot_score * $contest->problems()->where('pid', $submission->problem->pid)->first()->scores, 1);
                }
            }
            $data[] = [
                'sid' => $submission->sid,
                'name' => $submission->user->name,
                'nickname' => $submission->nick_name,
                'ncode' => $submission->ncode,
                'color' => $submission->color,
                'verdict' => $submission->verdict,
                'score_parse' => $score_parse,
                'time' => $submission->time,
                'memory' => $submission->memory,
                'language' => $submission->language,
                'submission_date' => date('Y-m-d H:i:s', $submission->submission_date),
                'submission_date_parsed' => $submission->submission_date_parsed
            ];
        }
        return response()->json([
            'success' => true,
            'message' => 'Succeed',
            'ret' => [
                'pagination' => $pagination,
                'data' => $data
            ],
            'err' => []
        ]);
    }

    public function scoreboard(Request $request) {
        $contest = $request->contest;
        $contestModel = new OutdatedContestModel();
        $contestRank = $contestModel->contestRank($contest->cid, auth()->check() ? auth()->user()->id : 0);

        //frozen about
        if($contest->forze_length != 0) {
            $frozen = [
                'enable' => true,
                'frozen_length' => $contest->forze_length
            ];
        }else{
            $frozen = [
                'enable' => false,
                'frozen_length' => 0
            ];
        }

        //header
        if($contest->rule == 1){
            $header = [
                'rank' => 'Rank',
                'normal' => [
                    'Account', 'Score', 'Penalty'
                ],
                'subHeader' => true,
                'problems' => [],
                'problemsSubHeader' => []
            ];
            $problems = $contest->problems;
            foreach($problems as $problem) {
                $header['problems'][] = $problem->ncode;
                $header['problemsSubHeader'][] = $problem->submissions()->where('submission_date', '<=', $contest->frozen_time)->where('verdict', 'Accepted')->count()
                                                . ' / ' . $problem->submissions()->where('submission_date', '<=', $contest->frozen_time)->count();
            }
        }else if($contest->rule == 2){
            $header = [
                'rank' => 'Rank',
                'normal' => [
                    'Account', 'Score', 'Solved'
                ],
                'subHeader' => false,
                'problems' => []
            ];
            $problems = $contest->problems;
            foreach($problems as $problem) {
                $header['problems'][] = $problem->ncode;
            }
        }


        //body
        if($contest->rule == 1){
            $body = [];
            $lastRank = null;
            $rank = 1;
            foreach($contestRank as $userRank) {
                $user = $contest->participants()->where('id', $userRank['uid'])->first();
                if(!empty($lastRank)) {
                    if($lastRank['score'] != $userRank['score'] || $lastRank['penalty'] != $userRank['penalty']) {
                        $rank += 1;
                    }
                }
                $lastRank = $userRank;
                $userBody = [
                    'rank'   => $rank,
                    'normal' => [
                        $userRank['name'], $userRank['score'], intval($userRank['penalty'])
                    ],
                    'problems' => []
                ];
                foreach($userRank['problem_detail'] as $problem) {
                    $userBody['problems'][] = [
                        'mainColor' => $problem['color'] === "" ? null : $problem['color'],
                        'mainScore' => $problem['solved_time_parsed'] === "" ? null : $problem['solved_time_parsed'],
                        'subColor' => null,
                        'subScore' => $problem['wrong_doings'] == 0 ? null : '-'.$problem['wrong_doings']
                    ];
                }
                $userBody['extra'] = [
                    'owner' => isset($userBody['remote']) && $userBody['remote'] ? false : auth()->user()->id == $user->id,
                    'remote' => $userBody['remote'] ?? false
                ];
                $body[] = $userBody;
            }
        }else if($contest->rule == 2){
            $body = [];
            $lastRank = null;
            $rank = 1;
            foreach($contestRank as $userRank) {
                $user = $contest->participants()->where('id', $userRank['uid'])->first();
                if(!empty($lastRank)) {
                    if($lastRank['score'] != $userRank['score'] || $lastRank['solved'] != $userRank['solved']) {
                        $rank += 1;
                    }
                }
                $lastRank = $userRank;
                $userBody = [
                    'rank'   => $rank,
                    'normal' => [
                        $userRank['name'], $userRank['score'], intval($userRank['solved'])
                    ],
                    'problems' => []
                ];
                foreach($userRank['problem_detail'] as $problem) {
                    $userBody['problems'][] = [
                        'mainColor' => $problem['color'] === "" ? null : $problem['color'],
                        'mainScore' => $problem['score'] === "" ? null : $problem['score_parsed'],
                        'subColor' => null,
                        'subScore' => null
                    ];
                }
                $userBody['extra'] = [
                    'owner' => isset($userBody['remote']) && $userBody['remote'] ? false : auth()->user()->id == $user->name,
                    'remote' => $userBody['remote'] ?? false
                ];
                $body[] = $userBody;
            }
        }


        return response()->json([
            'success' => true,
            'message' => 'Succeed',
            'ret' => [
                'frozen' => $frozen,
                'header' => $header,
                'body' => $body
            ],
            'err' => []
        ]);
    }

    public function clarification(Request $request) {
        $contest = $request->contest;
        return response()->json([
            'success' => true,
            'message' => 'Succeed',
            'ret' => [
                'clarifications' => $contest->clarifications()->orderBy('created_at', 'desc')->get()
            ],
            'err' => []
        ]);
    }

    public function requestClarification(Request $request) {
        if(empty($request->title) || empty($request->contest)) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter Missing',
                'ret' => [],
                'err' => [
                    'code' => 1100,
                    'msg' => 'Parameter Missing',
                    'data'=>[]
                ]
            ]);
        }
        $contest = $request->contest;
        $clarification = $contest->clarifications()->create([
            'cid' => $contest->cid,
            'type' => 1,
            'title' => $request->title,
            'content' => $request->content,
            'public' => 0,
            'uid' => auth()->user()->id
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Succeed.',
            'ret' => [
                "ccid" => $clarification->ccid,
            ],
            'err' => []
        ]);
    }

    public function problems(Request $request) {
        $contest = $request->contest;
        $contestProblems = $contest->problems()->with('problem')->orderBy('ncode', 'asc')->get();
        $problems = [];
        foreach($contestProblems as $contestProblem) {
            //get status
            $ac_submission = $contestProblem->submissions()->where('uid', auth()->user()->id)->where('verdict', 'Accepted')->orderBy('submission_date', 'desc')->first();
            $last_submission = $contestProblem->submissions()->where('uid', auth()->user()->id)->orderBy('submission_date', 'desc')->first();
            //get compilers
            $compilers_info = [];
            $compilers = $contestProblem->compilers;
            foreach($compilers as $compiler) {
                $compilers_info[] = [
                    'coid' => $compiler->coid,
                    'oid' => $compiler->oid,
                    'comp' => $compiler->comp,
                    'lang' => $compiler->lang,
                    'lcode' => $compiler->lcode,
                    'icon' => $compiler->icon,
                    'display_name' => $compiler->display_name
                ];
            }
            //build array
            if($contest->rule == 1 || $contest->rule == 3){
                $problems[] = [
                    'pid' => $contestProblem->pid,
                    'pcode' => $contestProblem->problem->pcode,
                    'ncode' => $contestProblem->ncode,
                    'title' => $contestProblem->problem->title,
                    'limitations' => [
                        'time_limit' => $contestProblem->problem->time_limit,
                        'memory_limit' => $contestProblem->problem->memory_limit,
                    ],
                    'statistics' => [
                        'accepted' => $contestProblem->submissions()->where('submission_date', '<=', $contest->frozen_time)->where('verdict', 'Accepted')->count(),
                        'attempted' => $contestProblem->submissions()->where('submission_date', '<=', $contest->frozen_time)->count(),
                        'score' => null
                    ],
                    'status' => [
                        'verdict' => !empty($ac_submission) ? $ac_submission->verdict : (!empty($last_submission) ? $last_submission->verdict : 'NOT SUBMIT'),
                        'color' => !empty($ac_submission) ? $ac_submission->color : (!empty($last_submission) ? $last_submission->color : ''),
                        'last_submission' => !empty($last_submission) ? [
                            'sid' => $last_submission->sid,
                            'verdict' => $last_submission->verdict,
                            'compile_info' => $last_submission->compile_info,
                            'color' => $last_submission->color,
                            'solution' => $last_submission->solution,
                            'coid' => $last_submission->coid,
                            'submission_date' => $last_submission->submission_date
                        ] : false
                    ],
                    'compilers' => $compilers_info
                ];
            }else if($contest->rule == 2 || $contest->rule == 4){

            }

        }
        return response()->json([
            'success' => true,
            'message' => 'Succeed',
            'ret' => [
                "file" => [
                    "enable" => false,
                    "name" => null,
                    "url" => null,
                    "extension" => null
                ],
                'problems' => $problems
            ],
            'err' => []
        ]);
    }
}
