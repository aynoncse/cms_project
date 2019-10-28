<?php

use App\Tag;
use App\Post;
use App\Category;
use App\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$author1 = User::create([
    		'name' 		=> 'John Doe',
    		'email' 	=> 'john@doe.com',
    		'password' 	=> Hash::make('12345678')
    	]);

    	$author2 = User::create([
    		'name' 		=> 'John Doe',
    		'email' 	=> 'jane@doe.com',
    		'password' 	=> Hash::make('12345678')
    	]);


    	$category1 = Category::create([
    		'name' => 'News'
    	]);
    	$category2 = Category::create([
    		'name' => 'Marketing'
    	]);
    	$category3 = Category::create([
    		'name' => 'Design'
    	]);

    	$post1 = $author1->posts()->create([
    		'title' 		=> 'We relocated our office to a new designed garage',
    		'description' 	=> 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
    		'content' 		=> 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
    		'category_id' 	=> $category1->id,
    		'image' 		=> 'posts/1.jpg'
    	]);

    	$post2 = $author1->posts()->create([
    		'title' 		=> 'Top 5 brilliant content marketing strategies',
    		'description' 	=> 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
    		'content' 		=> 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
    		'category_id' 	=> $category2->id,
    		'image' 		=> 'posts/2.jpg'
    	]);

    	$post3 = $author2->posts()->create([
    		'title' 		=> 'Best practices for minimalist design with example',
    		'description' 	=> 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
    		'content' 		=> 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
    		'category_id' 	=> $category3->id,
    		'image' 		=> 'posts/3.jpg'
    	]);

    	$post4 = $author2->posts()->create([
    		'title' 		=> 'Best practices for minimalist design with example',
    		'description' 	=> 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
    		'content' 		=> 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
    		'category_id' 	=> $category2->id,
    		'image' 		=> 'posts/4.jpg'
    	]);

    	$tag1 = Tag::create([
    		'name' => 'job'
    	]);
    	$tag2 = Tag::create([
    		'name' => 'customers'
    	]);
    	$tag3 = Tag::create([
    		'name' => 'record'
    	]);

    	$post1->tags()->attach([$tag1->id, $tag2->id]);
    	$post2->tags()->attach([$tag2->id, $tag3->id]);
    	$post3->tags()->attach([$tag1->id, $tag3->id]);
    }
}
