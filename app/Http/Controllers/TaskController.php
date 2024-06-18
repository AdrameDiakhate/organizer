<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request) {
        // Create task logic
    }
    
    public function update(Request $request, Task $task) {
        // Update task logic
    }
    
    public function destroy(Task $task) {
        // Delete task logic
    }
    
}
