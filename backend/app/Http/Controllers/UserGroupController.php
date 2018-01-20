<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;
use App\UserGroup;
use App\User;
use Auth;
class UserGroupController extends Controller {
  public function __construct() {
    $this->middleware('auth')->only('index');
  }
  public function index() {
    $classrooms = UserGroup::with('classroom')->where('user_id', Auth::id())->get();
  return $classrooms;
  }
  public function show(Classroom $classroom) {
 
  return $classroom;
  }
  public function membership(User $user, Classroom $classroom) {
    
      $classroom->subscribe();
    
  }



}