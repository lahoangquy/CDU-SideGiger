<?php

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->string('name');
            $table->string('slug');
            $table->boolean('active');
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });

        $categories = [
            [
                'parent' => [
                    'name' => 'Computing and IT',
                    'active' => true
                ],
                'subs' => [
                    [
                        'name' => 'Database',
                        'active' => true
                    ],
                    [
                        'name' => 'Software and programing',
                        'active' => true
                    ],
                    [
                        'name' => 'SharePoint',
                        'active' => true
                    ],
                    [
                        'name' => 'Web, Mobile, App development',
                        'active' => true
                    ]
                ]
            ],
            [
                'parent' => [
                    'name' => 'Data and Analytics',
                    'active' => true
                ],
                'subs' => [
                    [
                        'name' => 'Statistical analysis',
                        'active' => true
                    ],
                    [
                        'name' => 'Data entry',
                        'active' => true
                    ],
                    [
                        'name' => 'Data management',
                        'active' => true
                    ],
                    [
                        'name' => 'Data processing, preparation and cleaning',
                        'active' => true
                    ]
                ]
            ],
            [
                'parent' => [
                    'name' => 'Media and Design',
                    'active' => true
                ],
                'subs' => [
                    [
                        'name' => 'Animation',
                        'active' => true
                    ],
                    [
                        'name' => 'Graphic design',
                        'active' => true
                    ],
                    [
                        'name' => 'Web, Mobile, App development',
                        'active' => true
                    ],
                    [
                        'name' => 'Photography',
                        'active' => true
                    ],
                    [
                        'name' => 'Videography',
                        'active' => true
                    ]
                ]
            ],
            [
                'parent' => [
                    'name' => 'Marketing and Comms',
                    'active' => true
                ],
                'subs' => [
                    [
                        'name' => 'Content and copywriting',
                        'active' => true
                    ],
                    [
                        'name' => 'Social media',
                        'active' => true
                    ],
                ]
            ],
        ];

        foreach ($categories as $category) {
            $parentId = Category::create([
                'name' => $category['parent']['name'],
                'active' => true
            ])->id;

            foreach ($category['subs'] as $sub) {
                SubCategory::create([
                    'parent_id' => $parentId,
                    'name' => $sub['name'],
                    'active' => true
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_categories');
    }
}
