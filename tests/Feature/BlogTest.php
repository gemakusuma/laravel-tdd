<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BlogTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $this->blog = factory('App\Models\Blog')->create();
        $this->user = factory('App\Models\User')->create();
    }

    /** @test */
    public function user_can_see_blogpage()
    {
        $this->get('/blog')
            ->assertSee($this->blog->title);
    }

    /** @test */
    public function user_can_see_single_blogpage()
    {
        $this->get('/blog/' . $this->blog->slug)
            ->assertSee($this->blog->subject);
    }

    /** @test */
    public function guest_cant_post_a_blog()
    {
        $this->get('blog/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_post_a_blog()
    {
        $blog = $this->make_blog();

        $this->post('/blog', $blog->toArray())
             ->assertRedirect('/blog/'. $blog->slug);

         $this->get('/blog/'.$blog->slug)
              ->assertSee($blog->title)
              ->assertSee($this->user->name);
    }

    public function make_blog($fields = [])
    {
        $this->actingAs($this->user);
        return factory('App\Models\Blog')->make($fields);
    }


    /** @test */
    public function guest_cant_update_a_blog()
    {
        $this->get('blog/' . $this->blog->slug . '/edit')
            ->assertRedirect('/login');
    }

    /** @test */
    public function other_user_cant_update_others_blog()
    {
        $this->actingAs($this->user);
        $this->get('blog/'.$this->blog->slug.'/edit')
            ->assertStatus(403);

        $newTitle = 'this is new title';
        $newSubject = 'this is new subject';
        $this->json('PUT', '/blog/'.$this->blog->id, [
                'title' => $newTitle,
                'subject' => $newSubject,
            ])->assertStatus(403);
    }

    /** @test */
    public function authenticated_user_can_update_a_blog()
    {
        $this->actingAs($this->blog->user);
        $newTitle = 'this is new title';
        $newSubject = 'this is new subject';

        $slug = '/blog/'.$this->blog->slug;
        $this->json('PUT', '/blog/'.$this->blog->id, [
            'title' => $newTitle,
            'subject' => $newSubject,
        ])->assertRedirect($slug);

        $this->get($slug)->assertSee($newTitle)
                        ->assertSee($newSubject);
    }


//    /** @test */
//    public function blog_requires_title()
//    {
//        $blog = $this->make_blog(['title'=>null]);
//        $this->post('/blog', $blog->toArray())
//            ->assertSessionHasErrors('title');
//    }
//
//    /** @test */
//    public function blog_requires_subject()
//    {
//        $blog = $this->make_blog(['subject'=>null]);
//        $this->post('/blog', $blog->toArray())
//            ->assertSessionHasErrors('subject');
//    }
}
