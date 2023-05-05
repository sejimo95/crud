<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Statement\StoreRequest;
use App\Http\Requests\Api\Client\Statement\UpdateRequest;
use App\Http\Resources\Api\V1\Client\StatementResource;
use App\Models\Statement;

class StatementController extends Controller
{
    public function index(){
        $search = request()->search;
        $user = auth()->guard('client')->user();
        $limit = request()->rowsPerPage;
        $statemnt = Statement::where('user_id', $user->id);

        if($search) {
            $statemnt->where('name', 'like', "%$search%");
        }

        $data = $statemnt->paginate($limit);
        return StatementResource::collection($data)->additional(['success'  => true]);
    }

    public function store(StoreRequest $request)
    {
        $statement = Statement::create($request->validated());
        return response()->json(['message' => 'Successfully stored', 'statement' => $statement], 200);
    }

    public function update(UpdateRequest $request)
    {
        $user = auth()->guard('client')->user();
        $statement = Statement::where([['user_id', $user->id], ['id', $request->id]])->firstOrFail();
        $statement->update($request->validated());
        return response()->json(['message' => 'Successfully updated'], 200);
    }

    public function destroy($id)
    {
        $user = auth()->guard('client')->user();
        $statement = Statement::where([['user_id', $user->id], ['id', $id]])->firstOrFail();
        $statement->delete();
        return response()->json(['message' => 'Removed successfully'], 200);
    }
}
