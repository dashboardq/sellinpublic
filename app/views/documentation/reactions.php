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
                    <h2>Reactions</h2>
                    <p>There are nine endpoints for reaction information. Four public endpoint and five private endpoints that require a Pro account.</p>


					<hr>
					<h3>GET /reactions/flags/all</h3>
					<p>Public endpoint. Lists all the flags that have been created on the system. The meta information will provide pagination info.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/reactions/flags/all -u "demo:sip_api_sand_01234demo56789_key"</code>
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
      "url_next": "/api/v0/reactions/flags/all?page=1",
      "url_previous": "/api/v0/reactions/flags/all?page=1"
    }
  },
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "post_id": 6,
      "type": "flag",
      "content": null,
      "created_at": "2024-03-08T09:49:57+00:00",
      "updated_at": "2024-03-08T09:49:57+00:00",
      "created_tz": "2024-03-08T09:49:57+00:00",
      "updated_tz": "2024-03-08T09:49:57+00:00",
      "post": {
        "id": 6,
        "user_id": 4,
        "conversation_id": 6,
        "parent_id": 0,
        "original_id": 0, 
        "post": "Sometimes bad posts make it through moderation. If that happens they can be flagged. This post was flagged by the demo user.",
        "content": null,
        "status": "published",
        "type": "post",
        "depth": 0,
        "sort_order": null,
        "standing_calculated": 1,
        "replies": 1,
        "reposts": 0,
        "quotes": 0,
        "stars": 0,
        "flags": 1,
        "reactions": 0,
        "created_at": "2024-03-08T08:22:56+00:00",
        "updated_at": "2024-03-08T09:52:57+00:00",
        "published_at": "2024-03-08T08:22:56+00:00",
        "sorted_at": "2024-03-08T09:49:57+00:00",
        "username": "bad",
        "replied": false,
        "flagged": true,
        "starred": false,
        "sorted_tz": "2024-03-08T09:49:57+00:00",
        "display_name": "Bad",
        "bio": ""
      },
      "user": {
        "user_id": 1,
        "username": "demo",
        "display_name": "Demo",
        "bio": ""
      }
    }
  ]
}
</pre>
                    </div>


					<hr>
					<h3>GET /reactions/flags/{post_id}</h3>
					<p>Public endpoint. Lists all the flags for a specific post. The meta information will provide pagination info.</p>

                    <h4>URL params</h4>
                    <p><strong>post_id</strong>: integer<br>
                    The id of the post.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/reactions/flags/6 -u "demo:sip_api_sand_01234demo56789_key"</code>
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
      "url_next": "/api/v0/reactions/flags/6?page=1",
      "url_previous": "/api/v0/reactions/flags/6?page=1"
    }
  },
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "post_id": 6,
      "type": "flag",
      "content": null, 
      "created_at": "2024-03-08T09:49:57+00:00",
      "updated_at": "2024-03-08T09:49:57+00:00",
      "created_tz": "2024-03-08T09:49:57+00:00",
      "updated_tz": "2024-03-08T09:49:57+00:00",
      "post": {
        "id": 6,
        "user_id": 4,
        "conversation_id": 6,
        "parent_id": 0,
        "original_id": 0, 
        "post": "Sometimes bad posts make it through moderation. If that happens they can be flagged. This post was flagged by the demo user.",
        "content": null,
        "status": "published",
        "type": "post",
        "depth": 0,
        "sort_order": null,
        "standing_calculated": 1,
        "replies": 1,
        "reposts": 0,
        "quotes": 0,
        "stars": 0,
        "flags": 1,
        "reactions": 0,
        "created_at": "2024-03-08T08:22:56+00:00",
        "updated_at": "2024-03-08T09:52:57+00:00",
        "published_at": "2024-03-08T08:22:56+00:00",
        "sorted_at": "2024-03-08T09:49:57+00:00",
        "username": "bad",
        "replied": false,
        "flagged": true,
        "starred": false,
        "sorted_tz": "2024-03-08T09:49:57+00:00",
        "display_name": "Bad",
        "bio": ""
      },
      "user": {
        "user_id": 1,
        "username": "demo",
        "display_name": "Demo",
        "bio": ""
      }
    }
  ]
}
</pre>
                    </div>


					<hr>
					<h3>GET /reactions/stars/all</h3>
					<p>Public endpoint. Lists all the stars that have been created on the system. The meta information will provide pagination info.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/reactions/stars/all -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {
    "pagination": {
      "total_results": 2,
      "total_pages": 1,
      "page_previous": 1,
      "page_next": 1,
      "page_current": 1,
      "current_page": 1,
      "current_result": 1,
      "current_result_first": 1,
      "current_result_last": 2,
      "url_next": "/api/v0/reactions/stars/all?page=1",
      "url_previous": "/api/v0/reactions/stars/all?page=1"
    }
  },
  "data": [
    {
      "id": 3,
      "user_id": 1,
      "post_id": 2,
      "type": "star",
      "content": null,
      "created_at": "2024-03-08T10:13:17+00:00",
      "updated_at": "2024-03-08T10:13:17+00:00",
      "created_tz": "2024-03-08T10:13:17+00:00",
      "updated_tz": "2024-03-08T10:13:17+00:00",
      "post": {
        "id": 2,
        "user_id": 1,
        "conversation_id": 2,
        "parent_id": 0,
        "original_id": 0,
        "post": "Welcome to the Sandbox server where you can test the interface and API interactions!",
        "content": null,
        "status": "published",
        "type": "post",
        "depth": 0,
        "sort_order": null,
        "standing_calculated": 1,
        "replies": 3,
        "reposts": 0,
        "quotes": 0,
        "stars": 1,
        "flags": 0,
        "reactions": 0,
        "created_at": "2024-03-08T06:14:16+00:00",
        "updated_at": "2024-03-08T10:14:17+00:00",
        "published_at": "2024-03-08T06:14:16+00:00",
        "sorted_at": "2024-03-08T10:13:17+00:00",
        "username": "demo",
        "replied": false,
        "flagged": false,
        "starred": true,
        "sorted_tz": "2024-03-08T10:13:17+00:00",
        "display_name": "Demo",
        "bio": ""
      },
      "user": {
        "user_id": 1,
        "username": "demo",
        "display_name": "Demo",
        "bio": ""
      }
    },
    {
      "id": 2,
      "user_id": 1,
      "post_id": 7,
      "type": "star",
      "content": null,
      "created_at": "2024-03-08T10:12:17+00:00",
      "updated_at": "2024-03-08T10:12:17+00:00",
      "created_tz": "2024-03-08T10:12:17+00:00",
      "updated_tz": "2024-03-08T10:12:17+00:00",
      "post": {
        "id": 7,
        "user_id": 2,
        "conversation_id": 7,
        "parent_id": 0,
        "original_id": 0,
        "post": "The Sandbox server is regenerated every 24 hours.",
        "content": null,
        "status": "published",
        "type": "post",
        "depth": 0,
        "sort_order": null,
        "standing_calculated": 1,
        "replies": 0,
        "reposts": 0,
        "quotes": 0,
        "stars": 1,
        "flags": 0,
        "reactions": 0,
        "created_at": "2024-03-08T09:44:16+00:00",
        "updated_at": "2024-03-08T10:14:17+00:00",
        "published_at": "2024-03-08T09:44:16+00:00",
        "sorted_at": "2024-03-08T10:12:17+00:00",
        "username": "sandbox",
        "replied": false,
        "flagged": false,
        "starred": true,
        "sorted_tz": "2024-03-08T10:12:17+00:00",
        "display_name": "Sandbox",
        "bio": ""
      },
      "user": {
        "user_id": 1,
        "username": "demo",
        "display_name": "Demo",
        "bio": ""
      }
    }
  ]
}
</pre>
                    </div>


					<hr>
					<h3>GET /reactions/stars/{post_id}</h3>
					<p>Public endpoint. Lists all the stars for a specific post. The meta information will provide pagination info.</p>

                    <h4>URL params</h4>
                    <p><strong>post_id</strong>: integer<br>
                    The id of the post.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/reactions/stars/2 -u "demo:sip_api_sand_01234demo56789_key"</code>
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
      "url_next": "/api/v0/reactions/stars/2?page=1",
      "url_previous": "/api/v0/reactions/stars/2?page=1"
    }
  },
  "data": [
    {
      "id": 3,
      "user_id": 1,
      "post_id": 2,
      "type": "star",
      "content": null,
      "created_at": "2024-03-08T10:13:17+00:00",
      "updated_at": "2024-03-08T10:13:17+00:00",
      "created_tz": "2024-03-08T10:13:17+00:00",
      "updated_tz": "2024-03-08T10:13:17+00:00",
      "post": {
        "id": 2,
        "user_id": 1,
        "conversation_id": 2,
        "parent_id": 0,
        "original_id": 0,  
        "post": "Welcome to the Sandbox server where you can test the interface and API interactions!",
        "content": null,
        "status": "published",
        "type": "post",
        "depth": 0,
        "sort_order": null,
        "standing_calculated": 1,
        "replies": 3,
        "reposts": 0,
        "quotes": 0,
        "stars": 1,
        "flags": 0,
        "reactions": 0,
        "created_at": "2024-03-08T06:14:16+00:00",
        "updated_at": "2024-03-08T10:14:17+00:00",
        "published_at": "2024-03-08T06:14:16+00:00",
        "sorted_at": "2024-03-08T10:13:17+00:00",
        "username": "demo",
        "replied": false,
        "flagged": false,
        "starred": true,
        "sorted_tz": "2024-03-08T10:13:17+00:00",
        "display_name": "Demo",
        "bio": ""
      },
      "user": {
        "user_id": 1,
        "username": "demo",
        "display_name": "Demo",
        "bio": ""
      }
    }
  ]
}
</pre>
                    </div>


					<hr>
					<h3>GET /reactions/stars</h3>
					<p>Private endpoint. Lists all the stars for the current user. The meta information will provide pagination info.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/reactions/stars -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {
    "pagination": {
      "total_results": 2,
      "total_pages": 1,
      "page_previous": 1,
      "page_next": 1,
      "page_current": 1,
      "current_page": 1,
      "current_result": 1,
      "current_result_first": 1,
      "current_result_last": 2,
      "url_next": "/api/v0/reactions/stars?page=1",
      "url_previous": "/api/v0/reactions/stars?page=1"
    }
  },
  "data": [
    {
      "id": 3,
      "user_id": 1,
      "post_id": 2,
      "type": "star",
      "content": null,
      "created_at": "2024-03-08T10:13:17+00:00",
      "updated_at": "2024-03-08T10:13:17+00:00",
      "created_tz": "2024-03-08T10:13:17+00:00",
      "updated_tz": "2024-03-08T10:13:17+00:00", 
      "post": {
        "id": 2,
        "user_id": 1,
        "conversation_id": 2,
        "parent_id": 0,
        "original_id": 0,
        "post": "Welcome to the Sandbox server where you can test the interface and API interactions!",
        "content": null,
        "status": "published",
        "type": "post",
        "depth": 0,
        "sort_order": null,
        "standing_calculated": 1,
        "replies": 3,
        "reposts": 0,
        "quotes": 0,
        "stars": 1,
        "flags": 0,
        "reactions": 0,
        "created_at": "2024-03-08T06:14:16+00:00",
        "updated_at": "2024-03-08T10:14:17+00:00",
        "published_at": "2024-03-08T06:14:16+00:00",
        "sorted_at": "2024-03-08T10:13:17+00:00",
        "username": "demo",
        "replied": false,
        "flagged": false,
        "starred": true,
        "sorted_tz": "2024-03-08T10:13:17+00:00",
        "display_name": "Demo",
        "bio": ""
      },
      "user": {
        "user_id": 1,
        "username": "demo",
        "display_name": "Demo",
        "bio": ""
      }
    },
    {
      "id": 2,
      "user_id": 1,
      "post_id": 7,
      "type": "star",
      "content": null,
      "created_at": "2024-03-08T10:12:17+00:00",
      "updated_at": "2024-03-08T10:12:17+00:00",
      "created_tz": "2024-03-08T10:12:17+00:00",
      "updated_tz": "2024-03-08T10:12:17+00:00",
      "post": {
        "id": 7,
        "user_id": 2,
        "conversation_id": 7,
        "parent_id": 0,
        "original_id": 0,
        "post": "The Sandbox server is regenerated every 24 hours.",
        "content": null,
        "status": "published",
        "type": "post",
        "depth": 0,
        "sort_order": null,
        "standing_calculated": 1,
        "replies": 0,
        "reposts": 0,
        "quotes": 0,
        "stars": 1,
        "flags": 0,
        "reactions": 0,
        "created_at": "2024-03-08T09:44:16+00:00",
        "updated_at": "2024-03-08T10:14:17+00:00",
        "published_at": "2024-03-08T09:44:16+00:00",
        "sorted_at": "2024-03-08T10:12:17+00:00",
        "username": "sandbox",
        "replied": false,
        "flagged": false,
        "starred": true,
        "sorted_tz": "2024-03-08T10:12:17+00:00",
        "display_name": "Sandbox",
        "bio": ""
      },
      "user": {
        "user_id": 1,
        "username": "demo",
        "display_name": "Demo",
        "bio": ""
      }
    }
  ]
}
</pre>
                    </div>


					<hr>
					<h3>POST /flag/{post_id}</h3>
					<p>Private endpoint. Flag a post as spam or abusive content.</p>

                    <h4>URL params</h4>
                    <p><strong>post_id</strong>: integer<br>
                    The id of the post.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl -X POST https://sandbox.sellinpublic.com/api/v0/flag/8 -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {},
  "data": {
    "id": 8,
    "user_id": 1,
    "conversation_id": 8,
    "parent_id": 0,
    "original_id": 0,
    "post": "The Sandbox was regenerated five minutes after the time of this post.",
    "status": "published",
    "created_at": "2024-03-08T22:51:31+00:00",
    "updated_at": "2024-03-08T22:56:38+00:00",
    "published_at": "2024-03-08T22:51:31+00:00",
    "username": "demo",
    "display_name": "Demo",
    "bio": ""
  }
}
</pre>
                    </div>


					<hr>
					<h3>POST /star/{post_id}</h3>
					<p>Private endpoint. Mark a post with a star. Starring a post is kind of a cross between liking a post and bookmarking a post. It will notify the author of the post that it has been starred and all starred posts for a user account are available to retrieve.</p>

                    <h4>URL params</h4>
                    <p><strong>post_id</strong>: integer<br>
                    The id of the post.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl -X POST https://sandbox.sellinpublic.com/api/v0/star/8 -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {},
  "data": {
    "id": 8,
    "user_id": 1,
    "conversation_id": 8,
    "parent_id": 0,
    "original_id": 0,
    "post": "The Sandbox was regenerated five minutes after the time of this post.",
    "status": "published",
    "created_at": "2024-03-08T22:54:26+00:00",
    "updated_at": "2024-03-08T23:29:33+00:00",
    "published_at": "2024-03-08T22:54:26+00:00",
    "username": "demo",
    "display_name": "Demo",
    "bio": ""
  }
}
</pre>
                    </div>


					<hr>
					<h3>POST /unflag/{post_id}</h3>
					<p>Private endpoint. Remove a flag from a post that the user previously flagged.</p>

                    <h4>URL params</h4>
                    <p><strong>post_id</strong>: integer<br>
                    The id of the post.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl -X POST https://sandbox.sellinpublic.com/api/v0/unflag/8 -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {},
  "data": {
    "id": 8,
    "user_id": 1,
    "conversation_id": 8,
    "parent_id": 0,
    "original_id": 0,
    "post": "The Sandbox was regenerated five minutes after the time of this post.",
    "status": "published",
    "created_at": "2024-03-08T22:54:26+00:00",
    "updated_at": "2024-03-08T23:30:36+00:00",
    "published_at": "2024-03-08T22:54:26+00:00",
    "username": "demo",
    "display_name": "Demo",
    "bio": ""
  }
}
</pre>
                    </div>


					<hr>
					<h3>POST /unstar/{post_id}</h3>
					<p>Private endpoint. Remove a star from a post that the user previously starred.</p>

                    <h4>URL params</h4>
                    <p><strong>post_id</strong>: integer<br>
                    The id of the post.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl -X POST https://sandbox.sellinpublic.com/api/v0/unstar/8 -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {},
  "data": {
    "id": 8,
    "user_id": 1,
    "conversation_id": 8,
    "parent_id": 0,
    "original_id": 0,
    "post": "The Sandbox was regenerated five minutes after the time of this post.",
    "status": "published",
    "created_at": "2024-03-08T22:54:26+00:00",
    "updated_at": "2024-03-08T23:31:10+00:00",
    "published_at": "2024-03-08T22:54:26+00:00",
    "username": "demo",
    "display_name": "Demo",
    "bio": ""
  }
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

