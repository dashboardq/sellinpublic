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
                    <p>There are six endpoints for post information. Four public endpoints and two private endpoints that require a Pro account.</p>

					<hr>
					<h3>GET /latest</h3>
					<p>Public endpoint. Provides the latest posts. The meta information will provide pagination info.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
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
      "total_results": 4,                                                 
      "total_pages": 1,     
      "page_previous": 1,                                                                                                                            
      "page_next": 1,       
      "page_current": 1,
      "current_page": 1,
      "current_result": 1,
      "current_result_first": 1,
      "current_result_last": 4,
      "url_next": "/api/v0/latest?page=1",                                
      "url_previous": "/api/v0/latest?page=1"                             
    }                                                                                                                                                
  },             
  "data": [ 
    {            
      "id": 2,                                                            
      "user_id": 1,                                                       
      "conversation_id": 2,                                               
      "parent_id": 0,
      "original_id": 0,
      "post": "Welcome to the Sandbox server where you can test the interface and API interactions!",
      "status": "published",
      "type": "post",
      "depth": 0,
      "sort_order": null,
      "attachment_count": 0,
      "replies": 3,
      "reposts": 0,
      "quotes": 0,
      "stars": 1,
      "flags": 0,
      "reactions": 0,
      "bumps": 0,
      "created_at": "2024-03-23T04:42:04+00:00",
      "updated_at": "2024-03-23T08:42:04+00:00",
      "published_at": "2024-03-23T04:42:04+00:00",
      "sorted_at": "2024-03-23T08:41:04+00:00",
      "username": "demo",
      "replied": false,
      "flagged": false,
      "starred": true,
      "attachments": [],
      "user": {
        "user_id": 1,
        "username": "demo",
        "display_name": "Demo",
        "bio": "",
        "profile_image_url": "https://sandbox.sellinpublic.com/media/alphabet/d.png"
      }
    },
    {
      "id": 7,
      "user_id": 2,
      "conversation_id": 7,
      "parent_id": 0,
      "original_id": 0,
      "post": "The Sandbox server is regenerated every 24 hours.",
      "status": "published",
      "type": "post",
      "depth": 0,
      "sort_order": null,
      "attachment_count": 0,
      "replies": 0,
      "reposts": 0,
      "quotes": 0,
      "stars": 1,
      "flags": 0,
      "reactions": 0,
      "bumps": 0,
      "created_at": "2024-03-23T08:12:04+00:00",
      "updated_at": "2024-03-23T08:42:04+00:00",
      "published_at": "2024-03-23T08:12:04+00:00",
      "sorted_at": "2024-03-23T08:40:04+00:00",
      "username": "sandbox",
      "replied": false,
      "flagged": false,
      "starred": true,
      "attachments": [],
      "user": {
        "user_id": 2,
        "username": "sandbox",
        "display_name": "Sandbox",
        "bio": "",
        "profile_image_url": "https://sandbox.sellinpublic.com/media/alphabet/s.png"
      }
    },
    {
      "id": 6,
      "user_id": 4,
      "conversation_id": 6,
      "parent_id": 0,
      "original_id": 0,
      "post": "Sometimes bad posts make it through moderation. If that happens they can be flagged. This post was flagged by the demo user.",
      "status": "published",
      "type": "post",
      "depth": 0,
      "sort_order": null,
      "attachment_count": 0,
      "replies": 1,
      "reposts": 0,
      "quotes": 0,
      "stars": 0,
      "flags": 1,
      "reactions": 0,
      "bumps": 0,
      "created_at": "2024-03-23T07:12:04+00:00",
      "updated_at": "2024-03-23T08:42:04+00:00",
      "published_at": "2024-03-23T07:12:04+00:00",
      "sorted_at": "2024-03-23T08:39:04+00:00",
      "username": "bad",
      "replied": false,
      "flagged": true,
      "starred": false,
      "attachments": [],
      "user": {
        "user_id": 4,
        "username": "bad",
        "display_name": "Bad",
        "bio": "",
        "profile_image_url": "https://sandbox.sellinpublic.com/media/alphabet/b.png"
      }
    },
    {
      "id": 8,
      "user_id": 3,
      "conversation_id": 8,
      "parent_id": 0,
      "original_id": 0,
      "post": "The Sandbox was regenerated five minutes after the time of this post.",
      "status": "published",
      "type": "post",
      "depth": 0,
      "sort_order": null,
      "attachment_count": 0,
      "replies": 0,
      "reposts": 0,
      "quotes": 0,
      "stars": 0,
      "flags": 0,
      "reactions": 0,
      "bumps": 0,
      "created_at": "2024-03-23T08:37:04+00:00",
      "updated_at": "2024-03-23T08:37:04+00:00",
      "published_at": "2024-03-23T08:37:04+00:00",
      "sorted_at": "2024-03-23T08:37:04+00:00",
      "username": "good",
      "replied": false,
      "flagged": false,
      "starred": false,
      "attachments": [],
      "user": {
        "user_id": 3,
        "username": "good",
        "display_name": "Good",
        "bio": "",
        "profile_image_url": "https://sandbox.sellinpublic.com/media/100/profile_1.png"
      }
    }
  ]
}
</pre>
                    </div>

					<hr>
					<h3>GET /pending</h3>
					<p>Private endpoint. Provides the user's pending posts. The meta information will provide pagination info.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
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
      "id": 1,   
      "user_id": 1,                                                       
      "conversation_id": 1,                                               
      "parent_id": 0,                                                     
      "original_id": 0,
      "post": "This is a delayed post. When new accounts are created or when an account has been penalized, there is a delay until their posts are pu
blished publicly. Until then, the posts are listed under pending.",
      "status": "pending",
      "type": "post",
      "depth": 0,
      "sort_order": null,
      "attachment_count": 0,
      "replies": 0,
      "reposts": 0,
      "quotes": 0,
      "stars": 0,
      "flags": 0,
      "reactions": 0,
      "bumps": 0,
      "created_at": "2024-03-23T03:42:04+00:00",
      "updated_at": "2024-03-23T03:42:04+00:00",
      "published_at": "2024-03-25T08:42:04+00:00",
      "sorted_at": "2024-03-25T08:42:04+00:00",
      "username": "demo",
      "replied": false,
      "flagged": false,
      "starred": false,
      "attachments": [],
      "user": {
        "user_id": 1,
        "username": "demo",
        "display_name": "Demo",
        "bio": "",
        "profile_image_url": "https://sandbox.sellinpublic.com/media/alphabet/d.png"
      }
    }
  ]
}
</pre>
                    </div>

					<hr>
					<h3>POST /post</h3>
					<p>Private endpoint. Create a new post for the user.</p>

                    <h4>Request body</h4>
                    <p><strong>post</strong>: string<br>
                    The contents of the post.</p>
                    <p><strong>parent_id</strong>: integer (optional)<br>
                    When replying to a post, this is the id of the original post.</p>

                    <h4>Endpoint Post Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/post -u "demo:sip_api_sand_01234demo56789_key" -d "post=This is an example post created by the API."</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{                         
  "status": "success",
  "messages": [  
    "Thank you for submitting your post. It will be publicly displayed in 2 minutes. New accounts have a delay in publishing to help protect against 
spam."         
  ],           
  "meta": {},      
  "data": {    
    "id": 10,                                                             
    "user_id": 1,                                                         
    "conversation_id": 0,                                                 
    "parent_id": 0,                                                       
    "original_id": 0,  
    "post": "This is an example post created by the API.",
    "status": "pending",
    "type": "post",  
    "depth": 0,       
    "sort_order": null,
    "attachment_count": 0,
    "replies": 0,        
    "reposts": 0,            
    "quotes": 0,
    "stars": 0,                                                                                                                                      
    "flags": 0,
    "reactions": 0,
    "bumps": 0,
    "created_at": "2024-03-23T08:46:54+00:00",  
    "updated_at": "2024-03-23T08:46:54+00:00",
    "published_at": "2024-03-23T08:48:54+00:00",
    "sorted_at": "2024-03-23T08:48:54+00:00",
    "username": "demo",
    "replied": false,
    "flagged": false,
    "starred": false,
    "attachments": [],
    "user": {
      "user_id": 1,
      "username": "demo",
      "display_name": "Demo",
      "bio": "",
      "profile_image_url": "https://sandbox.sellinpublic.com/media/alphabet/d.png"
    }
  }
}
</pre>
                    </div>

                    <h4>Endpoint Reply Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/post -u "demo:sip_api_sand_01234demo56789_key" -d "post=This is a reply created by the API." -d "parent_id=7"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{                         
  "status": "success",
  "messages": [  
    "Thank you for submitting your post. It will be publicly displayed in 2 minutes. New accounts have a delay in publishing to help protect against 
spam."         
  ],           
  "meta": {},      
  "data": {    
    "id": 11,                                                             
    "user_id": 1,                                                         
    "conversation_id": 7,                                                 
    "parent_id": 7,                                                       
    "original_id": 0,  
    "post": "This is a reply created by the API.",
    "status": "pending",
    "type": "reply", 
    "depth": 0,       
    "sort_order": null,
    "attachment_count": 0,
    "replies": 0,        
    "reposts": 0,            
    "quotes": 0,
    "stars": 0,                                                                                                                                      
    "flags": 0,
    "reactions": 0,
    "bumps": 0,
    "created_at": "2024-03-23T08:48:32+00:00",  
    "updated_at": "2024-03-23T08:48:32+00:00",
    "published_at": "2024-03-23T08:50:32+00:00",
    "sorted_at": "2024-03-23T08:50:32+00:00",
    "username": "demo",
    "replied": false,
    "flagged": false,
    "starred": false,
    "attachments": [],
    "user": {
      "user_id": 1,
      "username": "demo",
      "display_name": "Demo",
      "bio": "",
      "profile_image_url": "https://sandbox.sellinpublic.com/media/alphabet/d.png"
    }
  }
}
</pre>
                    </div>

                    <h4>Endpoint Text Attachment Example</h4>
					<p>Below is a live example that can be copy and pasted that has multiline text and two additional text attachments. The $'...' text allows for newline characters to be sent by curl.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/post -u "demo:sip_api_sand_01234demo56789_key" -d "post=This is a post with two text attachments created by the API." -d "attachment_count=2" -d "attachment_type_0=text" -d $'attachment_text_0=This is some text.\n\nThis is some additional text.' -d "attachment_type_1=text" -d "attachment_text_1=This is another text attachment."</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{                         
  "status": "success",
  "messages": [       
    "Thank you for submitting your post. It will be publicly displayed in 2 minutes. New accounts have a delay in publishing to help protect against 
spam."                                                                    
  ],                    
  "meta": {},                                                             
  "data": {                                                               
    "id": 10,                                                             
    "user_id": 1,                                                         
    "conversation_id": 0,                                                 
    "parent_id": 0,                                                       
    "original_id": 0,  
    "post": "This is a post with two text attachments created by the API.",
    "status": "pending",                                                  
    "type": "post",     
    "depth": 0,                                                           
    "sort_order": null,                                                   
    "attachment_count": 2,
    "replies": 0,    
    "reposts": 0,     
    "quotes": 0,       
    "stars": 0,                                                           
    "flags": 0,              
    "reactions": 0,                                                       
    "bumps": 0,                                                                                                                                      
    "created_at": "2024-03-23T09:08:46+00:00",
    "updated_at": "2024-03-23T09:08:46+00:00",
    "published_at": "2024-03-23T09:10:46+00:00",
    "sorted_at": "2024-03-23T09:10:46+00:00", 
    "username": "demo",
    "replied": false,
    "flagged": false,
    "starred": false,
    "attachments": [
      {
        "id": 1,
        "user_id": 1,
        "post_id": 10,
        "type": "text",
        "content": "This is some text.\n\nThis is some additional text.",
        "sort_order": 0,
        "created_at": "2024-03-23T09:08:46+00:00",
        "updated_at": "2024-03-23T09:08:46+00:00"
      },
      {
        "id": 2,
        "user_id": 1,
        "post_id": 10,
        "type": "text",
        "content": "This is another text attachment.",
        "sort_order": 1,
        "created_at": "2024-03-23T09:08:46+00:00",
        "updated_at": "2024-03-23T09:08:46+00:00"
      }
    ],
    "user": {
      "user_id": 1,
      "username": "demo",
      "display_name": "Demo",
      "bio": "",
      "profile_image_url": "https://sandbox.sellinpublic.com/media/alphabet/d.png"
    }
  }
}
</pre>
                    </div>

					<hr>
					<h3>GET /post/children/{post_id}</h3>
					<p>Public endpoint. Provides a post and its children. The meta information will provide pagination info.</p>
                    <h4>URL params</h4>
                    <p><strong>post_id</strong>: integer<br>
                    The id of the post.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/post/children/2 -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{                    
  "status": "success",
  "messages": [],                                                         
  "meta": {                                                               
    "pagination": {                                                       
      "total_results": 4,                                                 
      "total_pages": 1,     
      "page_previous": 1,                                                                                                                            
      "page_next": 1,       
      "page_current": 1,
      "current_page": 1,
      "current_result": 1,                                                                                                                           
      "current_result_first": 1,
      "current_result_last": 4,
      "url_next": "/api/v0/post/children/2?page=1",
      "url_previous": "/api/v0/post/children/2?page=1"
    }                                                                                                                                                
  },             
  "data": [  
    {            
      "id": 2,                                                            
      "user_id": 1,                                                       
      "conversation_id": 2,                                               
      "parent_id": 0,
      "original_id": 0,
      "post": "Welcome to the Sandbox server where you can test the interface and API interactions!",
      "status": "published",
      "type": "post",
      "depth": 0,
      "sort_order": null,
      "attachment_count": 0,
      "replies": 3,
      "reposts": 0,
      "quotes": 0,
      "stars": 1,
      "flags": 0,
      "reactions": 0,
      "bumps": 0,
      "created_at": "2024-03-23T04:42:04+00:00",
      "updated_at": "2024-03-23T08:42:04+00:00",
      "published_at": "2024-03-23T04:42:04+00:00",
      "sorted_at": "2024-03-23T08:41:04+00:00",
      "username": "demo",
      "replied": false,
      "flagged": false,
      "starred": true,
      "attachments": [],
      "user": {
        "user_id": 1,
        "username": "demo",
        "display_name": "Demo",
        "bio": "",
        "profile_image_url": "https://sandbox.sellinpublic.com/media/alphabet/d.png"
      }
    },
    {
      "id": 3,
      "user_id": 2,
      "conversation_id": 2,
      "parent_id": 2,
      "original_id": 0,
      "post": "You can post replies.",
      "status": "published",
      "type": "reply",
      "depth": 1,
      "sort_order": "0000000001/0000000000/0000000000/00000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000",
      "attachment_count": 0,
      "replies": 1,
      "reposts": 0,
      "quotes": 0,
      "stars": 0,
      "flags": 0,
      "reactions": 0,
      "bumps": 0,
      "created_at": "2024-03-23T05:42:04+00:00",
      "updated_at": "2024-03-23T05:42:04+00:00",
      "published_at": "2024-03-23T05:42:04+00:00",
      "sorted_at": "2024-03-23T05:42:04+00:00",
      "username": "sandbox",
      "replied": false,
      "flagged": false,
      "starred": false,
      "attachments": [],
      "user": {
        "user_id": 2,
        "username": "sandbox",
        "display_name": "Sandbox",
        "bio": "",
        "profile_image_url": "https://sandbox.sellinpublic.com/media/alphabet/s.png"
      }
    },
    {
      "id": 5,
      "user_id": 1,
      "conversation_id": 2,
      "parent_id": 3,
      "original_id": 0,
      "post": "And you can thread replies.",
      "status": "published",
      "type": "reply",
      "depth": 2,
      "sort_order": "0000000001/0000000001/0000000000/00000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000",
      "attachment_count": 0,
      "replies": 0,
      "reposts": 0,
      "quotes": 0,
      "stars": 0,
      "flags": 0,
      "reactions": 0,
      "bumps": 0,
      "created_at": "2024-03-23T06:12:04+00:00",
      "updated_at": "2024-03-23T06:12:04+00:00",
      "published_at": "2024-03-23T06:12:04+00:00",
      "sorted_at": "2024-03-23T06:12:04+00:00",
      "username": "demo",
      "replied": false,
      "flagged": false,
      "starred": false,
      "attachments": [],
      "user": {
        "user_id": 1,
        "username": "demo",
        "display_name": "Demo",
        "bio": "",
        "profile_image_url": "https://sandbox.sellinpublic.com/media/alphabet/d.png"
      }
    },
    {
      "id": 4,
      "user_id": 3,
      "conversation_id": 2,
      "parent_id": 2,
      "original_id": 0,
      "post": "Feel free to start testing today! Checkout the API documentation if you need help:\nhttps://sellinpublic.com/documentation",
      "status": "published",
      "type": "reply",
      "depth": 1,
      "sort_order": "0000000002/0000000000/0000000000/00000000000/0000000000/0000000000/0000000000/0000000000/0000000000/0000000000",
      "attachment_count": 0,
      "replies": 0,
      "reposts": 0,
      "quotes": 0,
      "stars": 0,
      "flags": 0,
      "reactions": 0,
      "bumps": 0,
      "created_at": "2024-03-23T05:57:04+00:00",
      "updated_at": "2024-03-23T05:57:04+00:00",
      "published_at": "2024-03-23T05:57:04+00:00",
      "sorted_at": "2024-03-23T05:57:04+00:00",
      "username": "good",
      "replied": false,
      "flagged": false,
      "starred": false,
      "attachments": [],
      "user": {
        "user_id": 3,
        "username": "good",
        "display_name": "Good",
        "bio": "",
        "profile_image_url": "https://sandbox.sellinpublic.com/media/100/profile_1.png"
      }
    }
  ]
}
</pre>
                    </div>

					<hr>
					<h3>GET /post/single/{post_id}</h3>
					<p>Public endpoint. Provides the contents of a post.</p>

                    <h4>URL params</h4>
                    <p><strong>post_id</strong>: integer<br>
                    The id of the post.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/post/single/2 -u "demo:sip_api_sand_01234demo56789_key"</code>
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
      "url_next": "/api/v0/post/single/2?page=1",
      "url_previous": "/api/v0/post/single/2?page=1"
    }                                                                                                                                                
  },             
  "data": [  
    {            
      "id": 2,                                                            
      "user_id": 1,                                                       
      "conversation_id": 2,                                               
      "parent_id": 0,
      "original_id": 0,
      "post": "Welcome to the Sandbox server where you can test the interface and API interactions!",
      "status": "published",
      "type": "post",
      "depth": 0,
      "sort_order": null,
      "attachment_count": 0,
      "replies": 3,
      "reposts": 0,
      "quotes": 0,
      "stars": 1,
      "flags": 0,
      "reactions": 0,
      "bumps": 0,
      "created_at": "2024-03-23T04:42:04+00:00",
      "updated_at": "2024-03-23T08:42:04+00:00",
      "published_at": "2024-03-23T04:42:04+00:00",
      "sorted_at": "2024-03-23T08:41:04+00:00",
      "username": "demo",
      "replied": false,
      "flagged": false,
      "starred": true,
      "attachments": [],
      "user": {
        "user_id": 1,
        "username": "demo",
        "display_name": "Demo",
        "bio": "",
        "profile_image_url": "https://sandbox.sellinpublic.com/media/alphabet/d.png"
      }
    }
  ]
}
</pre>
                    </div>

					<hr>
					<h3>GET /timeline/user/{username}</h3>
					<p>Public endpoint. Provides the user posts. The meta information will provide pagination info.</p>
                    <h4>URL params</h4>
                    <p><strong>username</strong>: string<br>
                    The username for the account.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
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
      "total_results": 1,                                                 
      "total_pages": 1,     
      "page_previous": 1,                                                 
      "page_next": 1,       
      "page_current": 1,
      "current_page": 1,
      "current_result": 1,
      "current_result_first": 1,
      "current_result_last": 1,
      "url_next": "/api/v0/timeline/user/sandbox?page=1",
      "url_previous": "/api/v0/timeline/user/sandbox?page=1"
    }                                                                                                                                                
  },             
  "data": [ 
    {            
      "id": 7,                                                            
      "user_id": 2,                                                       
      "conversation_id": 7,                                               
      "parent_id": 0,
      "original_id": 0,
      "post": "The Sandbox server is regenerated every 24 hours.",
      "status": "published",
      "type": "post",
      "depth": 0,
      "sort_order": null,
      "attachment_count": 0,
      "replies": 1,
      "reposts": 0,
      "quotes": 0,
      "stars": 1,
      "flags": 0,
      "reactions": 0,
      "bumps": 1,
      "created_at": "2024-03-23T08:12:04+00:00",
      "updated_at": "2024-03-23T08:51:01+00:00",
      "published_at": "2024-03-23T08:12:04+00:00",
      "sorted_at": "2024-03-23T08:51:01+00:00",
      "username": "sandbox",
      "replied": true,
      "flagged": false,
      "starred": true,
      "attachments": [],
      "user": {
        "user_id": 2,
        "username": "sandbox",
        "display_name": "Sandbox",
        "bio": "",
        "profile_image_url": "https://sandbox.sellinpublic.com/media/alphabet/s.png"
      }
    }
  ]
}
</pre>
                    </div>

                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

