namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
protected $fillable = ['title', 'body', 'created_user_id'];

public static function getFilteredPosts($searchTerm = null)
{
$user = Auth::user();
$query = self::query();

if ($user->type != 1) {
$query->where('created_user_id', $user->id);
}

if ($searchTerm) {
$query->where(function ($q) use ($searchTerm) {
$q->where('title', 'LIKE', "%{$searchTerm}%")
->orWhere('body', 'LIKE', "%{$searchTerm}%");
});
}

return $query->get();
}
}
namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService
{
public function getPosts($searchTerm = null)
{
return Post::getFilteredPosts($searchTerm);
}

public function createPost($validatedData)
{
$validatedData['created_user_id'] = Auth::user()->id;
return Post::create($validatedData);
}

public function uploadCsvData($csvData)
{
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

public function generateExcelFile($searchTerm = null)
{
$posts = $this->getPosts($searchTerm);

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
return $writer;
}
}



namespace App\Http\Controllers;

use App\Services\PostService;
use App\Http\Requests\PostCreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
protected $postService;

public function __construct(PostService $postService)
{
$this->postService = $postService;
}

public function postListPage(Request $request)
{
$searchTerm = $request->input('searchKey');
$posts = $this->postService->getPosts($searchTerm);

return view('post.postList', compact('posts', 'searchTerm'));
}

public function postCreatePage()
{
return view('post.createPost');
}

public function postAdd(PostCreateRequest $request)
{
try {
$this->postService->createPost($request->validated());

return redirect()->route('post.postlist')->with('success', 'Post Creation Success.');
} catch (\Exception $e) {
return redirect()->back()->withErrors($e->getMessage())->withInput();
}
}

public function uploadCsv(Request $request)
{
if ($request->hasFile('csv_file')) {
$file = $request->file('csv_file');
$csvData = file_get_contents($file);

$this->postService->uploadCsvData($csvData);
}

return redirect()->route('post.postlist')->with('success', 'CSV data uploaded successfully.');
}

public function downloadExcel(Request $request)
{
$searchTerm = $request->input('searchKey');
$writer = $this->postService->generateExcelFile($searchTerm);

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






// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use App\Http\Requests\PostEditRequest;
use App\Http\Requests\PostUpdateRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
protected $postService;

public function __construct(PostService $postService)
{
$this->postService = $postService;
}

public function edit(Post $post)
{
return view('posts.edit', compact('post'));
}

public function previewEdit(PostEditRequest $request, Post $post)
{
$validatedData = $request->validated();
$updatedPost = $this->postService->handleEditPreview($post, $validatedData);

return view('posts.previewEdit', compact('post', 'updatedPost'));
}

public function update(PostUpdateRequest $request, Post $post)
{
$validatedData = $request->validated();
$this->postService->updatePost($post, $validatedData);

return redirect()->route('posts.edit', $post)->with('success', 'Post updated successfully.');
}
}
// app/Services/PostService.php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService
{
public function handleEditPreview($post, $validatedData)
{
// Prepare data for preview
$updatedPost = [
'title' => $validatedData['title'],
'body' => $validatedData['body'],
'status' => $post->status, // Keep the original status
];

return $updatedPost;
}

public function updatePost(Post $post, array $data)
{
// Update the post with the confirmed data
$post->update([
'title' => $data['title'],
'body' => $data['body'],
]);

return $post;
}
}
