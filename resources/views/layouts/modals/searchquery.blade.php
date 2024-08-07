<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class User extends Model
{
    // Other model methods and properties...

    public function scopeSearch($query, $filters)
    {
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        if (isset($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }
        if (isset($filters['startDate']) && isset($filters['endDate'])) {
            $query->whereBetween('created_at', [$filters['startDate'], $filters['endDate']]);
        }

        if (Auth::user()->type !== 1) { // Assuming 1 is the admin type
            $query->where('created_user_id', Auth::id());
        }

        return $query;
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['name', 'email', 'startDate', 'endDate']);
        $users = User::search($filters)->paginate(10);

        return view('user_list', compact('users'));
    }
}
