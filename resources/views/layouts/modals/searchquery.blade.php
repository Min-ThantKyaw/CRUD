use App\Models\User;
use Illuminate\Http\Request;

public function search(Request $request)
{
$filters = $request->only(['name', 'email', 'startDate', 'endDate']);
$users = User::search($filters)->get();

return view('users.index', compact('users'));
}
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
// Define the search scope
public function scopeSearch($query, $filters)
{
if (!empty($filters['name'])) {
$query->where('name', 'like', '%' . $filters['name'] . '%');
}

if (!empty($filters['email'])) {
$query->where('email', 'like', '%' . $filters['email'] . '%');
}

if (!empty($filters['startDate']) && empty($filters['endDate'])) {
$query->whereDate('created_at', $filters['startDate']);
} elseif (!empty($filters['startDate']) && !empty($filters['endDate'])) {
$query->whereDate('created_at', '>=', $filters['startDate'])
->whereDate('created_at', '<=', $filters['endDate']); } elseif (empty($filters['startDate']) &&
    !empty($filters['endDate'])) { $query->whereDate('created_at', '<=', $filters['endDate']); } return $query; } }
