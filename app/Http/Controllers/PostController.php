<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use App\Http\Requests\PostCreateRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function postListPage(Request $request)
    {
        $user = Auth::user();
        $searchTerm = $request->input('searchKey');

        $query = Post::query();

        if ($user->type != 1) {
            $query->where('created_user_id', $user->id);
        }

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('body', 'LIKE', "%{$searchTerm}%");
            });
        }

        $posts = $query->get();

        return view('post.postList', compact('posts', 'searchTerm'));
    }
    public function postEdit($id)
    {
        $post = Post::find($id);
        return view('post.editPost', compact('post'));
    }
    public function previewEdit(Request $request, Post $post)
    {
        // Gather the edited data to preview
        $updatePost = $request->only(['title', 'body']);
        $updatedPost['status'] = $post->status; // Maintain the original status

        return view('post.confirmEditPost', compact('post', 'updatePost'));
    }
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
        ]);

        // Update the post with the confirmed data
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('post.postlist', $post)->with('success', 'Post updated successfully.');
    }
    public function postCreatePage()
    {
        return view('post.createPost');
    }

    protected $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    public function postAdd(PostCreateRequest $request)
    {
        try {
            $post = $this->postService->postAdd($request->validated());

            return redirect()->route('post.postlist')->with('success', 'Post Creation Success.');
        } catch (\Exception $e) {
            return response()->json();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    //Csv function

    public function uploadCsv(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $csvData = file_get_contents($file);
            $rows = array_map('str_getcsv', explode("\n", $csvData));
            $header = array_shift($rows);

            foreach ($rows as $row) {
                if (count($header) == count($row)) {
                    $row = array_combine($header, $row);
                    Post::create([
                        'title' => $row['title'],
                        'body' => $row['body'],
                        'created_user_id' => Auth::user()->id,
                    ]);
                }
            }
        }

        return redirect()->route('post.postlist')->with('success', 'CSV data uploaded successfully.');
    }

    public function downloadExcel(Request $request)
    {
        $user = Auth::user();
        $searchTerm = $request->input('searchKey');

        $query = Post::query();

        if ($user->type != 1) {
            $query->where('created_user_id', $user->id);
        }

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('body', 'LIKE', "%{$searchTerm}%");
            });
        }

        $posts = $query->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Title');
        $sheet->setCellValue('C1', 'Body');
        $sheet->setCellValue('D1', 'Created User ID');
        $sheet->setCellValue('E1', 'Created At');

        // Add data rows
        $row = 2;
        foreach ($posts as $post) {
            $sheet->setCellValue('A' . $row, $post->id);
            $sheet->setCellValue('B' . $row, $post->title);
            $sheet->setCellValue('C' . $row, $post->body);
            $sheet->setCellValue('D' . $row, $post->created_user_id);
            $sheet->setCellValue('E' . $row, $post->created_at);
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $filename = 'posts.xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
}
