<!DOCTYPE html>                
<html>
    <head>                     
        <?php $res->partial('head'); ?>
    </head>
    <body class="<?php $res->pathClass(); ?> page_documentation">
        <?php $res->partial('view_app_before'); ?>
        <div id="app" class="columns_2">
            <?php $res->partial('header'); ?>
            <?php $res->partial('sidebar_documentation'); ?> 
            <main>
                <div id="content" class="page">
                    <h2>Posts</h2>
                    <p>There are three endpoints for post information. One public endpoint and two private endpoints that require a Pro account.</p>

					<hr>
					<h3>GET /latest</h3>
					<p>Provides the latest posts. The meta information will provide pagination info.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/latest -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{                                                                                                                                                    
  "status": "success",                                                                                                                               
  "messages": [],                                                         
  "meta": {                                                               
    "pagination": {                                                                                                                                  
      "total_results": 3,   
      "total_pages": 1,         
      "page_previous": 1,                                                 
      "page_next": 1,                                                     
      "page_current": 1,                                                  
      "current_page": 1,    
      "current_result": 1,      
      "current_result_first": 1,                                                                                                                     
      "current_result_last": 3,
      "url_next": "/api/v0/latest?page=1",
      "url_previous": "/api/v0/latest?page=1"                             
    }                                                                     
  },                                                                                                                                                 
  "data": [                 
    {                           
      "id": 3,                                                            
      "user_id": 1,                                                       
      "post": "The sandbox server will be automatically reset at specific intervals (initially thinking every 24 hours).",
      "content": "",        
      "status": "published",                                              
      "created_at": "2024-02-09T01:52:58+00:00",
      "updated_at": "2024-02-09T02:09:26+00:00",
      "published_at": "2024-02-09T01:52:58+00:00",
      "username": "sandbox",
      "display_name": "Sandbox",
      "bio": null
    },
    {
      "id": 2,
      "user_id": 1,
      "post": "The sandbox server has just been created. It will be providing fake user login and API testing options in the future.",
      "content": "",
      "status": "published",
      "created_at": "2024-02-09T01:51:55+00:00",
      "updated_at": "2024-02-09T02:09:26+00:00",
      "published_at": "2024-02-09T01:51:55+00:00",
      "username": "sandbox",
      "display_name": "Sandbox",
      "bio": null
    },
    {
      "id": 1,
      "user_id": 1,
      "post": "Welcome to the Sandbox server where you can test the interface and API interactions!",
      "content": "",
      "status": "published",
      "created_at": "2024-02-09T01:50:12+00:00",
      "updated_at": "2024-02-09T02:09:26+00:00",
      "published_at": "2024-02-09T01:50:12+00:00",
      "username": "sandbox",
      "display_name": "Sandbox",
      "bio": null
    }
  ]
}</pre>
                    </div>

					<hr>
					<h3>GET /pending</h3>
					<p>Provides the user's pending posts. The meta information will provide pagination info.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/pending -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {
    "pagination": {
      "total_results": 1,
      "total_pages": 1,
      "page_previous": 1,
      "page_next": 1,
      "page_current": 1,
      "current_page": 1,
      "current_result": 1,
      "current_result_first": 1,
      "current_result_last": 1,
      "url_next": "/api/v0/pending?page=1",
      "url_previous": "/api/v0/pending?page=1"
    }
  },
  "data": [
    {
      "id": 5,
      "user_id": 2,
      "post": "This is a pending post.",
      "content": null,
      "status": "pending",
      "created_at": "2024-02-21T06:46:56+00:00",
      "updated_at": "2024-02-21T06:46:56+00:00",
      "published_at": "2024-02-23T06:46:56+00:00",
      "username": "demo",
      "display_name": "Demo Updated",
      "bio": ""
    }
  ]
}</pre>
                    </div>

					<hr>
					<h3>POST /post</h3>
					<p>Create a new post for the user.</p>
                    <h4>Request body</h4>
                    <p><strong>post</strong>: string<br>
                    The contents of the post.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/post -u "demo:sip_api_sand_01234demo56789_key" -d "post=This is an example post created by the API."</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [
    "Thank you for submitting your post. It will be publicly displayed in 48 hours. New accounts have a delay in publishing to help protect against spam."
  ],
  "meta": {},
  "data": {
    "id": "8",
    "user_id": 2,
    "post": "This is an example post created by the API.",
    "status": "pending",
    "created_at": "2024-02-21T08:46:08+00:00",
    "updated_at": "2024-02-21T08:46:08+00:00",
    "published_at": "2024-02-23T08:46:08+00:00",
    "username": "demo",
    "display_name": "Demo User",
    "bio": ""
  }
}</pre>
                    </div>

					<hr>
					<h3>GET /post/children/{post_id}</h3>
					<p>Provides a post and its children. The meta information will provide pagination info.</p>
                    <h4>URL params</h4>
                    <p><strong>post_id</strong>: integer<br>
                    The id of the post.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/post/children/1 -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {
    "pagination": {
      "total_results": 1,
      "total_pages": 1,
      "page_previous": 1,
      "page_next": 1,
      "page_current": 1,
      "current_page": 1,
      "current_result": 1,
      "current_result_first": 1,
      "current_result_last": 1,
      "url_next": "/api/v0/post/children/1?page=1",
      "url_previous": "/api/v0/post/children/1?page=1"
    }
  },
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "post": "Welcome to the Sandbox server where you can test the interface and API interactions!",
      "content": "",
      "status": "published",
      "created_at": "2024-02-09T01:50:12+00:00",
      "updated_at": "2024-02-09T02:09:26+00:00",
      "published_at": "2024-02-09T01:50:12+00:00",
      "username": "sandbox",
      "display_name": "Sandbox",
      "bio": null
    }
  ]
}</pre>
                    </div>

					<hr>
					<h3>GET /post/single/{post_id}</h3>
					<p>Provides the contents of a post.</p>
                    <h4>URL params</h4>
                    <p><strong>post_id</strong>: integer<br>
                    The id of the post.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/post/single/1 -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {
    "pagination": {
      "total_results": 1,
      "total_pages": 1,
      "page_previous": 1,
      "page_next": 1,
      "page_current": 1,
      "current_page": 1,
      "current_result": 1,
      "current_result_first": 1,
      "current_result_last": 1,
      "url_next": "/api/v0/post/single/1?page=1",
      "url_previous": "/api/v0/post/single/1?page=1"
    }
  },
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "post": "Welcome to the Sandbox server where you can test the interface and API interactions!",
      "content": "",
      "status": "published",
      "created_at": "2024-02-09T01:50:12+00:00",
      "updated_at": "2024-02-09T02:09:26+00:00",
      "published_at": "2024-02-09T01:50:12+00:00",
      "username": "sandbox",
      "display_name": "Sandbox",
      "bio": null
    }
  ]
}</pre>
                    </div>

					<hr>
					<h3>GET /timeline/user/{username}</h3>
					<p>Provides the user posts. The meta information will provide pagination info.</p>
                    <h4>URL params</h4>
                    <p><strong>username</strong>: string<br>
                    The username for the account.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/timeline/user/sandbox -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{                                                                                                                                                    
  "status": "success",                                                                                                                               
  "messages": [],                                                         
  "meta": {                                                               
    "pagination": {                                                                                                                                  
      "total_results": 3,   
      "total_pages": 1,         
      "page_previous": 1,                                                 
      "page_next": 1,                                                     
      "page_current": 1,                                                  
      "current_page": 1,    
      "current_result": 1,      
      "current_result_first": 1,                                                                                                                     
      "current_result_last": 3,
      "url_next": "/api/v0/timeline/user/sandbox?page=1",
      "url_previous": "/api/v0/timeline/user/sandbox?page=1"                             
    }                                                                     
  },                                                                                                                                                 
  "data": [                 
    {                           
      "id": 3,                                                            
      "user_id": 1,                                                       
      "post": "The sandbox server will be automatically reset at specific intervals (initially thinking every 24 hours).",
      "content": "",        
      "status": "published",                                              
      "created_at": "2024-02-09T01:52:58+00:00",
      "updated_at": "2024-02-09T02:09:26+00:00",
      "published_at": "2024-02-09T01:52:58+00:00",
      "username": "sandbox",
      "display_name": "Sandbox",
      "bio": null
    },
    {
      "id": 2,
      "user_id": 1,
      "post": "The sandbox server has just been created. It will be providing fake user login and API testing options in the future.",
      "content": "",
      "status": "published",
      "created_at": "2024-02-09T01:51:55+00:00",
      "updated_at": "2024-02-09T02:09:26+00:00",
      "published_at": "2024-02-09T01:51:55+00:00",
      "username": "sandbox",
      "display_name": "Sandbox",
      "bio": null
    },
    {
      "id": 1,
      "user_id": 1,
      "post": "Welcome to the Sandbox server where you can test the interface and API interactions!",
      "content": "",
      "status": "published",
      "created_at": "2024-02-09T01:50:12+00:00",
      "updated_at": "2024-02-09T02:09:26+00:00",
      "published_at": "2024-02-09T01:50:12+00:00",
      "username": "sandbox",
      "display_name": "Sandbox",
      "bio": null
    }
  ]
}</pre>
                    </div>

                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

