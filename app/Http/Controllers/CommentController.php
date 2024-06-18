<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Task $task) {
        // Create comment logic
    }
    
    public function update(Request $request, Comment $comment) {
        // Update comment logic
    }
    
    public function destroy(Comment $comment) {
        // Delete comment logic
    }
    }
