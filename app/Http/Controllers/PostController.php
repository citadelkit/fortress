<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Citadel\Components\Layout\Form;
use Citadel\Components\Layout\Card;
use Citadel\Components\Form\TextArea;
use Citadel\Components\Layout\CustomView;
use Citadel\Components\Page;
use Citadel\Components\Table;
use Citadel\Core\Wrapper;
use Citadel\Components\HeaderText;
use Citadel\Components\Control\Button;
use Citadel\Components\Support\Icon;
use Citadel\Events\FormSubmitEvent;
use Citadel\Components\Layout\ActionGroup;
use Citadel\Components\Support\Gradient;
use Citadel\Components\Widget;
use Citadel\Components\Control\SweetAlert;
use Citadel\Citadel;
use Citadel\Components\Layout\Accordions;
use Citadel\Components\Layout\Accordion;
use Citadel\Components\Layout\Tabs;
use Citadel\Components\Layout\Tab;





class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Page::make('All Post')
            // ->alt1()
            ->sidebar(view('menu.admin'))
            ->business(function () {
                $query = Post::select('id', 'title', 'excerpt', 'created_by', 'total_read');
                return compact('query');
            })
            ->schema([
                Wrapper::make('Header')
                    ->columns(4)
                    ->schema([
                        HeaderText::make('hd:allPost', 'All Post')
                            ->colspan(3)
                            ->textClass('text-primary'),
                        // ->class("text-white"),
                    ]),
                Wrapper::make('Widget')
                    ->columns(4)
                    ->schema([
                        Widget::make('Dibaca')
                            ->setReactive(function () {
                                return '';
                            })
                            ->color(Gradient::SUNSET),
                    ]),
                Wrapper::make('header-action')
                    // ->columns(4)
                    ->schema([
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
                    ->filters([])
                    ->numbering()
                    ->query(fn($query) => $query)
                    ->schema([
                        // Table\Column::make('id', __("ID")),
                        Table\Column::make('title', __("Judul"))->searchable()->orderable(),
                        Table\Column::make('excerpt', __("Sinopsis"))->searchable()->orderable(),
                        Table\Column::make('created_by', __("Dibuat oleh")),
                        Table\Column::make('total_read', __("x dibaca")),
                    ])
                    ->actions(
                        function ($model) {
                            return [
                                Button::make('view', __("Edit"))
                                    ->icon(Icon::Edit)
                                    ->to(route('post.edit', $model->id)),
                                ActionGroup::make('more')
                                    ->dropdown()
                                    ->schema([
                                        Button::make('Delete')
                                            ->icon(Icon::Trash)
                                            ->onClick(
                                                SweetAlert::make('delete_data', 'Hapus Data')
                                                    ->showCancelButton(true)
                                                    ->confirmButtonText("Ya!")
                                                    ->cancelButtonText("Tidak")
                                                    ->content('Yakin ?')
                                                    ->afterConfirm('post', route('post.destroy', ['id' => $model->id]))

                                            ),
                                        // ->to(fn($model) => route('post.destroy', $model->id)),
                                        Button::make('Disable')
                                            ->icon(Icon::Edit2)
                                            ->disabled(true),
                                        Button::make('Hide')
                                            ->icon(Icon::Edit)
                                            ->show(false),
                                    ])
                            ];
                        }
                    )

            ])
            ->render();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Page::make('All Post')
            // ->alt1()
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
                            // ->noHeader()
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
            'title' => ["string", "max:200"],
            'body' => ["string"]
        ]);

        Post::create([
            ...$validated,
            'excerpt' => substr($validated['body'], 0, 200),
            'created_by' => 1,
        ]);

        return Citadel::response(
            SweetAlert::make('success', 'Success')
                ->content("Berhasil Edit Post")
                ->type('success')
                ->route('post.index')
            // ->afterConfirm('reload')
        );


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
    public function edit($id, Request $request)
    {
        //
        $model = Post::findOrFail($id);
        return Page::make('All Post')
            // ->alt1()
            ->sidebar(view('menu.admin'))
            ->schema([
                Wrapper::make('header')
                    ->columns(4)
                    ->schema([
                        HeaderText::make('hd:updatePost', 'Edit Post')
                            ->colspan(3)
                            ->class("text-white"),
                        Wrapper::make('action')
                            ->flex('justify-content: end')
                            ->schema([
                                Button::make('update', __('Update'))
                                    ->icon(Icon::Save)
                                    ->onClick(
                                        FormSubmitEvent::form('main_form')
                                            ->to(route('post.update', $id))
                                            ->default()
                                    )->route('post.update', $id)
                            ])
                    ]),
                Form::make('main_form')
                    ->schema([
                        Card::make('Update Post')
                            // ->noHeader()
                            ->schema([
                                CustomView::make('primary')
                                    ->view('modules.post.create_form', ['model' => $model]),
                                // Accordions::make('acc')
                                //     ->schema([
                                //         Accordion::make('acc-1', __("Detail"))
                                //             ->schema([]),
                                //         Accordion::make('acc-2', __("Detail"))
                                //             ->schema([])

                                //     ])

                            ]),
                    ])

            ])
            ->render();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request,)
    {
        //
        $validated = $request->validate([
            'title' => ["required", "string", "max:200"],
            'body' => ["required", "string"]
        ]);

        Post::where('id', $id)->update([
            ...$validated,
            'excerpt' => substr($validated['body'], 0, 200),
            'updated_by' => 1,
        ]);

        return Citadel::response(
            SweetAlert::make('success', 'Success')
                ->content("Berhasil Edit Post")
                ->type('success')
                ->route('post.index')
            // ->afterConfirm('reload')
        );

        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        //
        $model = Post::findOrFail($id);
        $model->delete();

        if ($request->header('x-request-via') == 'citadel-ajax') {
            return Citadel::response(
                SweetAlert::make('delete_data', 'Hapus Data')
                    ->content("Berhasil Hapus Data")
                    // ->route('post.index')
                    // ->afterConfirm('reload')
                    ->event(["event" => "CTable:reload", "form_name" => "form-filter-post_table", "table_name" => "post_table"])
            );
        }

        return redirect()->route('post.index');
    }

    public function arrayTest()
    {
        return Page::make('All Post')
            // ->alt1()
            ->sidebar(view('menu.admin'))
            ->business(function () {
                // $query = Post::select('id', 'title', 'excerpt', 'created_by', 'total_read');
                $query = [
                    ["title" => "The Rise of Laravel", "excerpt" => "A deep dive into Laravel's popularity.", "created_by" => 1, "total_read" => 120],
                    ["title" => "Vue.js in Practice", "excerpt" => "Examples and use cases for Vue.js.", "created_by" => 1, "total_read" => 95],
                    ["title" => "Mastering Tailwind CSS", "excerpt" => "Quick tips to design faster.", "created_by" => 1, "total_read" => 80],
                    ["title" => "JavaScript Async Explained", "excerpt" => "Understanding async/await in JavaScript.", "created_by" => 1, "total_read" => 140],
                    ["title" => "Clean Code in PHP", "excerpt" => "How to keep your PHP code clean and maintainable.", "created_by" => 1, "total_read" => 110],
                    ["title" => "React vs Vue", "excerpt" => "Comparing two popular frontend frameworks.", "created_by" => 1, "total_read" => 150],
                    ["title" => "MySQL Optimization", "excerpt" => "Improve your database performance.", "created_by" => 1, "total_read" => 75],
                    ["title" => "Building REST APIs", "excerpt" => "Designing clean and scalable APIs.", "created_by" => 1, "total_read" => 130],
                    ["title" => "Intro to MongoDB", "excerpt" => "Learn NoSQL with MongoDB.", "created_by" => 1, "total_read" => 90],
                    ["title" => "Java for Backend", "excerpt" => "Using Java and Spring Boot for APIs.", "created_by" => 1, "total_read" => 85],
                    ["title" => "Docker Basics", "excerpt" => "Get started with containerized development.", "created_by" => 1, "total_read" => 100],
                    ["title" => "Debugging in Laravel", "excerpt" => "How to find and fix bugs efficiently.", "created_by" => 1, "total_read" => 105],
                    ["title" => "API Security Essentials", "excerpt" => "Protect your endpoints with best practices.", "created_by" => 1, "total_read" => 115],
                    ["title" => "Testing with PHPUnit", "excerpt" => "Write better tests for your PHP code.", "created_by" => 1, "total_read" => 88],
                    ["title" => "Deploying with GitHub Actions", "excerpt" => "Automate deployments using CI/CD pipelines.", "created_by" => 1, "total_read" => 92],
                ];

                return compact('query');
            })
            ->schema([
                Wrapper::make('Header')
                    ->columns(4)
                    ->schema([
                        HeaderText::make('hd:allPost', 'All Post')
                            ->colspan(3)
                            ->class("text-white"),
                    ]),
                Wrapper::make('Widget')
                    ->columns(4)
                    ->schema([
                        Widget::make('Dibaca')
                            ->setReactive(function () {
                                return '';
                            })
                            ->color(Gradient::SUNSET),
                    ]),
                Wrapper::make('header-action')
                    // ->columns(4)
                    ->schema([
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
                    ->filters([])
                    // ->numbering()
                    ->array(fn($query) => $query)
                    ->schema([
                        // Table\Column::make('id', __("ID")),
                        Table\Column::make('title', __("Judul"))
                            ->searchable()
                            ->orderable(),
                        Table\Column::make('excerpt', __("Sinopsis"))
                            ->searchable()
                            ->orderable(),
                        Table\Column::make('created_by', __("Dibuat oleh")),
                        Table\Column::make('total_read', __("x dibaca")),
                    ])
                // ->actions(
                //     function ($model) {
                //         return [
                //             Button::make('view', __("Edit"))
                //                 ->icon(Icon::Edit)
                //                 ->to(route('post.edit', $model->id)),
                //             ActionGroup::make('more')
                //                 ->dropdown()
                //                 ->schema([
                //                     Button::make('Delete')
                //                         ->icon(Icon::Trash)
                //                         ->onClick(
                //                             SweetAlert::make('delete_data', 'Hapus Data')
                //                                 ->showCancelButton(true)
                //                                 ->confirmButtonText("Ya!")
                //                                 ->cancelButtonText("Tidak")
                //                                 ->content('Yakin ?')
                //                             ->afterConfirm('post', route('post.destroy', ['id' => $model->id]))

                //                         ),
                //                     // ->to(fn($model) => route('post.destroy', $model->id)),
                //                     Button::make('Disable')
                //                         ->icon(Icon::Edit2)
                //                         ->disabled(true),
                //                     Button::make('Hide')
                //                         ->icon(Icon::Edit)
                //                         ->show(false),
                //                 ])
                //         ];
                //     }
                // )

            ])
            ->render();
    }

    public function tabDirection()
    { {
            return Page::make('All Post')
                // ->alt1()
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
                                // ->noHeader()
                                ->schema([
                                    Tabs::make('Tabs-bp-row')
                                        ->direction('row')
                                        ->schema([
                                            Tab::make('history', 'Riwayat Aktivitas')
                                                ->view('modules.post.create_form', ['model' => optional()]),
                                            Tab::make('history2', 'Riwayat Aktivitas2')
                                                ->view('modules.post.create_form', ['model' => optional()]),

                                        ]),
                                    Tabs::make('Tabs-bp-column')
                                        ->direction('column')
                                        ->schema([
                                            Tab::make('history3', 'Riwayat Aktivitas 3')
                                                ->view('modules.post.create_form', ['model' => optional()]),
                                            Tab::make('history4', 'Riwayat Aktivitas4 ')
                                                ->view('modules.post.create_form', ['model' => optional()]),
                                        ]),    
                                    // CustomView::make('primary')
                                    //     ->view('modules.post.vertical-tabs', ['model' => optional()]),
                                ]),

                        ])

                ])
                ->render();
        }
    }
}
