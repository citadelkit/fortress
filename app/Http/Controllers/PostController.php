<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Citadel\Components\Layout\Form;
use Citadel\Components\Layout\Card;
use Citadel\Components\Layout\CustomView;
use Citadel\Components\Page;
use Citadel\Components\Table;
use Citadel\Core\Wrapper;
use Citadel\Components\HeaderText;
use Citadel\Components\Control\Button;
use Citadel\Components\Support\Icon;
use Citadel\Events\FormSubmitEvent;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Page::make('All Post')
            ->alt1()
            ->sidebar(view('menu.admin'))
            ->schema([
                Wrapper::make('header')
                    ->columns(4)
                    ->schema([
                        HeaderText::make('hd:allPost', 'All Post')
                            ->colspan(3)
                            ->class("text-white"),
                        Wrapper::make('action')
                            ->flex('justify-content: end')
                            ->schema([
                                Button::make('create', __('New Post'))
                                    ->icon(Icon::PlusCircle)
                                    ->route('post.create')
                            ])
                    ]),
                Table\Table::make('post_table')
                    ->normal()
                    ->query(Post::select('title', 'excerpt', 'created_by', 'total_read'))
                    ->schema([
                        Table\Column::make('title', __("Judul")),
                        Table\Column::make('excerpt', __("Sinopsis")),
                        Table\Column::make('created_by', __("Dibuat oleh")),
                        Table\Column::make('total_read', __("x dibaca")),
                    ])
            ])
            ->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Page::make('All Post')
            ->alt1()
            ->sidebar(view('menu.admin'))
            ->schema([
                Wrapper::make('header')
                    ->columns(4)
                    ->schema([
                        HeaderText::make('hd:createPost', 'Create Post')
                            ->colspan(3)
                            ->class("text-white"),
                        Wrapper::make('action')
                            ->flex('justify-content: end')
                            ->schema([
                                Button::make('create', __('Submit'))
                                    ->icon(Icon::Save)
                                    ->onClick(
                                        FormSubmitEvent::form('main_form')
                                            ->to(route('post.store'))
                                            ->default()
                                    )
                                    ->route('post.create')
                            ])
                    ]),
                Form::make('main_form')
                    ->schema([
                        Card::make('New Post')
                            ->noHeader()
                            ->schema([
                                CustomView::make('primary')
                                    ->view('modules.post.create_form', ['model' => optional()]),
                            ]),
                    ])

            ])
            ->render();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ["string","max:200"],
            'body' => ["string"]
        ]);

        Post::create([
            ...$validated,
            'excerpt' => substr($validated['body'], 0, 200),
            'created_by' => 1,
        ]);

        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
