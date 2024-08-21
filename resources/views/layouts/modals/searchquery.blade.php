<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User; // Ensure you import the User model
use App\Services\PostService; // Adjust according to your service class

class PostServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $postService;
    protected $user; // To store the created user

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and log them in
        $this->user = User::create([
            'name' => 'Min Thant Kyaw',
            'email' => 'minthant1590@gmail.com',
            'password' => Hash::make('Min553238@'),
            'phone' => '09-880576046',
            'address' => 'Kanbalu',
            'type' => '0',
            'dob' => Carbon::create('2000', '01', '01'),
            'created_user_id' => '1',
            'updated_user_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),


        ],); // Adjust according to your User factory
        Auth::login($this->user); // Log in the user for the duration of the test

        $this->postService = new PostService(); // Adjust according to your actual service class
    }

    /** @test */
    public function it_can_create_a_post()
    {
        $data = [
            'title' => 'Test Post Title',
            'description' => 'Test Post Description',
        ];

        $post = $this->postService->createPost($data);

        // Assert that the post was created in the database
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post Title',
            'description' => 'Test Post Description',
            'status' => 1,
            'created_user_id' => $this->user->id,
            'updated_user_id' => $this->user->id,
        ]);

        // Assert that a post object was returned
        $this->assertInstanceOf(Post::class, $post);
    }
    public function it_can_update_a_post()
    {
        $data = [
            'title' => 'Test Post Title',
            'description' => 'Test Post Description',
        ];

        $post = $this->postService->createPost($data);

        // New data for the update
        $newData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'status' => 1,
        ];

        // Call the update method
        $updatedPost = $this->postService->updatePost($post, $newData);

        // Assert that the post was updated in the database
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'status' => 1,
            'updated_user_id' => $this->user->id,
        ]);

        // Assert that the returned post is the updated post
        $this->assertInstanceOf(Post::class, $updatedPost);
        $this->assertEquals('Updated Title', $updatedPost->title);
        $this->assertEquals('Updated Description', $updatedPost->description);
        $this->assertEquals(1, $updatedPost->status);
        $this->assertEquals($this->user->id, $updatedPost->updated_user_id);
    }
    public function it_returns_false_when_trying_to_delete_a_non_existent_post()
    {
        // Create a post and delete it
        $data = [
            'title' => 'Test Post Title',
            'description' => 'Test Post Description',
        ];

        $post = $this->postService->createPost($data);
        // Ensure the post exists in the database
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
        ]);

        // Call the soft delete method with the post ID
        $result = $this->postService->softDeletePost($post->id);

        // Assert that the delete method returned true
        $this->assertTrue($result);

        // Assert that the post no longer exists in the database
        $this->assertSoftDeleted('posts', [
            'id' => $post->id,
        ]);
    }
    public function it_can_create_a_post_from_csv_data()
    {
        // CSV data as a string
        $csvData = "title,description\nTest Post Title 1,Test Post Description 1\nTest Post Title 2,Test Post Description 2";

        // Call the uploadCsvData method
        $this->postService->uploadCsvData($csvData);

        // Assert that the posts were created in the database
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post Title 1',
            'description' => 'Test Post Description 1',
            'created_user_id' => $this->user->id,
            'updated_user_id' => $this->user->id,
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post Title 2',
            'description' => 'Test Post Description 2',
            'created_user_id' => $this->user->id,
            'updated_user_id' => $this->user->id,
        ]);
    }
    public function it_can_generate_an_excel_file()
    {
        // Create some posts
        Post::factory()->count(3)->create([
            'created_user_id' => $this->user->id,
            'updated_user_id' => $this->user->id,
        ]);

        // Call the generateExcelFile method
        $writer = $this->postService->generateExcelFile();

        // Save the generated Excel file to a temporary location
        $filePath = storage_path('app/public/posts.xlsx');
        $writer->save($filePath);

        // Load the saved Excel file
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        $this->assertEquals('ID', $sheet->getCell('A1')->getValue());
        $this->assertEquals('Title', $sheet->getCell('B1')->getValue());
        $this->assertEquals('Description', $sheet->getCell('C1')->getValue());
        $this->assertEquals('Ststus', $sheet->getCell('D1')->getValue());
        $this->assertEquals('Created User ID', $sheet->getCell('E1')->getValue());
        $this->assertEquals('Updated User ID', $sheet->getCell('F1')->getValue());
        $this->assertEquals('Deleted User ID', $sheet->getCell('G1')->getValue());
        $this->assertEquals('Created At', $sheet->getCell('H1')->getValue());
        $this->assertEquals('Updated At', $sheet->getCell('I1')->getValue());
        $this->assertEquals('Deleted At', $sheet->getCell('J1')->getValue());

        // Check the data rows
        $row = 2;
        foreach (Post::all() as $post) {
            $this->assertEquals($post->id, $sheet->getCell('A' . $row)->getValue());
            $this->assertEquals($post->title, $sheet->getCell('B' . $row)->getValue());
            $this->assertEquals($post->description, $sheet->getCell('C' . $row)->getValue());
            $this->assertEquals($post->status, $sheet->getCell('D' . $row)->getValue());
            $this->assertEquals($post->created_user_id, $sheet->getCell('E' . $row)->getValue());
            $this->assertEquals($post->updated_user_id, $sheet->getCell('F' . $row)->getValue());
            $this->assertEquals($post->deleted_user_id, $sheet->getCell('G' . $row)->getValue());
            $this->assertEquals($post->created_at->format('Y/m/d'), $sheet->getCell('H' . $row)->getValue());
            $this->assertEquals($post->updated_at->format('Y/m/d'), $sheet->getCell('I' . $row)->getValue());
            $this->assertEquals($post->deleted_at, $sheet->getCell('J' . $row)->getValue());
            $row++;
        }

        // Clean up the generated file
        unlink($filePath);
    }
}
<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'phone' => $this->faker->unique()->phoneNumber,
            'address' => $this->faker->optional()->address,
            'type' => $this->faker->numberBetween(0, 1),
            'dob' => $this->faker->optional()->date('Y-m-d'),
            'profile' => $this->faker->optional()->imageUrl(),
            'created_user_id' => $this->faker->numberBetween(1, 10),
            'updated_user_id' => $this->faker->numberBetween(1, 10),
            'deleted_user_id' => null,
        ];
    }
}
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Random;
use Ramsey\Uuid\Type\Integer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title(),
            'body' => $this->faker->paragraph(),
            'status' => $this->faker->numberBetween(0, 1),
            'created_user_id' => Auth::id(),
            'updated_user_id' => Auth::id(),
        ];
    }
}
public function softDeletePost(int $id): bool
    {
        $post = Post::find($id);
        if ($post) {
            return $post->delete();
        }

        return false;
    }
    public function destroy($id): RedirectResponse
    {
        $deleted = $this->postService->softDeletePost($id);
        if ($deleted) {
            return redirect()->route('post.postlist')->with('success', 'Post deleted successfully.');
        } else {
            return redirect()->route('post.postlist')->with('error', 'Post not found.');
        }
    }
