<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Soher\Work\Domain\Status;

class WorkController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        if (!Auth::user()->can('work.index')) {
            return response()->json(['statusText' => 'Unauthorized'], 401);
        }

        $works = Work::with('client')
            ->matching($request->search, 'title', 'description', 'skills')
            ->matching($request->status, 'status')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($works);
    }

    public function store(Request $request): JsonResponse
    {
        if (!Auth::user()->can('work.create')) {
            return response()->json(['statusText' => 'Unauthorized'], 401);
        }

        $rules = [
            'title' => 'required|min:10|max:70',
            'location' => 'required|min:10|max:100',
            'description' => 'required|min:10|max:2000',
            'skills' => 'required|array',
            'budget' => 'required|numeric|min:1|max_digits:6',
            'deadline' => 'required|date',
            'photo' => 'image|nullable'
        ];

        $validator = Validator::make($request->all(), $rules);
        $validator->validate();

        $photoPath = $request->hasFile('photo')
            ? str_replace('public', '/storage', $request->file('photo')->store('/public/images'))
            : null;

        $work = Work::create([
            'client_id' => Auth::id(),
            'status' => Status::OPEN->value,
            'photo' => $photoPath,
            ...$request->except('photo')
        ]);

        return response()->json($work, 201);
    }

    public function show(int $id): JsonResponse
    {
        $work = Work::with('client')->findOrFail($id);

        if (Auth::id() !== $work->client->id) {
            return response()->json(['statusText' => 'Unauthorized'], 401);
        }

        return response()->json($work);
    }

    public function update(Request $request, Work $work)
    {
        if (Auth::id() !== $work->client->id) {
            return response()->json(['statusText' => 'Unauthorized'], 401);
        }

        $rules = [
            'title' => 'required|min:10|max:70',
            'location' => 'required|min:10|max:100',
            'description' => 'required|min:10|max:2000',
            'skills' => 'required|array',
            'budget' => 'required|numeric|min:1|max_digits:6',
            'deadline' => 'required|date',
            'photo' => 'image|nullable'
        ];

        $validator = Validator::make($request->all(), $rules);
        $validator->validate();

        if ($request->hasFile('photo')) {
            $work->update([
                'photo' => str_replace('public', '/storage', $request->file('photo')->store('/public/images')),
                ...$request->except('photo')
            ]);
        } else {
            $work->update($request->all());
        }

        return response()->json($work, 201);
    }
}
