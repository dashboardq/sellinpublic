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
                    <h2>Notifications</h2>
                    <p>There are seven private endpoints for notifications that require a Pro account.</p>

					<hr>
					<h3>GET /notifications</h3>
					<p>Private endpoint. Provides a list of notifications for the user account. The meta information will provide pagination info.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/notifications -u "demo:sip_api_sand_01234demo56789_key"</code>
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
      "url_next": "/api/v0/notifications?page=1",
      "url_previous": "/api/v0/notifications?page=1"                                                                                                 
    }                                                                                                                                                
  },  
  "data": [              
    {                                                                     
      "id": 2,                                                            
      "receiver_id": 1,                                                   
      "receiver_post_id": 2,                                              
      "initiator_id": 3,
      "initiator_post_id": 4,
      "type": "reply",
      "status": "unread",
      "content": null,
      "created_at": "2024-03-23T05:46:24+00:00",
      "updated_at": "2024-03-23T05:46:24+00:00",
      "initiator": {
        "display_name": "Good",
        "username": "good",
        "bio": "",
        "profile_image_url": "https://sandbox.sellinpublic.com/media/100/profile_1.png"
      },
      "initiator_post": {
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
        "created_at": "2024-03-23T05:46:24+00:00",
        "updated_at": "2024-03-23T05:46:24+00:00",
        "published_at": "2024-03-23T05:46:24+00:00",
        "sorted_at": "2024-03-23T05:46:24+00:00",
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
      },
      "receiver_post": {
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
        "created_at": "2024-03-23T04:31:24+00:00",
        "updated_at": "2024-03-23T08:31:25+00:00",
        "published_at": "2024-03-23T04:31:24+00:00",
        "sorted_at": "2024-03-23T08:30:25+00:00",
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
    },
    {
      "id": 1,
      "receiver_id": 1,
      "receiver_post_id": 2,
      "initiator_id": 2,
      "initiator_post_id": 3,
      "type": "reply",
      "status": "read",
      "content": null,
      "created_at": "2024-03-23T05:31:24+00:00",
      "updated_at": "2024-03-23T05:31:24+00:00",
      "initiator": {
        "display_name": "Sandbox",
        "username": "sandbox",
        "bio": "",
        "profile_image_url": "https://sandbox.sellinpublic.com/media/alphabet/s.png"
      },
      "initiator_post": {
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
        "created_at": "2024-03-23T05:31:24+00:00",
        "updated_at": "2024-03-23T05:31:24+00:00",
        "published_at": "2024-03-23T05:31:24+00:00",
        "sorted_at": "2024-03-23T05:31:24+00:00",
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
      "receiver_post": {
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
        "created_at": "2024-03-23T04:31:24+00:00",
        "updated_at": "2024-03-23T08:31:25+00:00",
        "published_at": "2024-03-23T04:31:24+00:00",
        "sorted_at": "2024-03-23T08:30:25+00:00",
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
    }
  ]
}
</pre>
                    </div>

					<hr>
					<h3>GET /notifications/count</h3>
					<p>Private endpoint. Provides the count of notifications. The meta information will provide pagination info.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/notifications/count -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": [],
  "data": 2
}
</pre>
                    </div>

					<hr>
					<h3>GET /notifications/count/unread</h3>
					<p>Private endpoint. Provides the count of unread notifications. The meta information will provide pagination info.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/notifications/count/unread -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": [],
  "data": 1
}
</pre>
                    </div>


					<hr>
					<h3>POST /notification/read/{notification_id}</h3>
					<p>Private endpoint. Marks the specific notification as read.</p>

                    <h4>URL params</h4>
                    <p><strong>notification_id</strong>: integer<br>
                    The id of the notification.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl -X POST https://sandbox.sellinpublic.com/api/v0/notification/read/2 -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [
    "Item marked as read."
  ],
  "meta": {},
  "data": {}
}
</pre>
                    </div>


					<hr>
					<h3>POST /notification/unread/{notification_id}</h3>
					<p>Private endpoint. Marks the specific notification as unread.</p>

                    <h4>URL params</h4>
                    <p><strong>notification_id</strong>: integer<br>
                    The id of the notification.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl -X POST https://sandbox.sellinpublic.com/api/v0/notification/unread/2 -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [
    "Item marked as unread."
  ],
  "meta": {},
  "data": {}
}
</pre>
                    </div>


					<hr>
					<h3>POST /notifications/read</h3>
					<p>Private endpoint. Marks all the notifications as read.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl -X POST https://sandbox.sellinpublic.com/api/v0/notifications/read -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [
    "All items marked as read."
  ],
  "meta": {},
  "data": {}
}
</pre>
                    </div>


					<hr>
					<h3>POST /notifications/unread</h3>
					<p>Private endpoint. Marks all the notifications as unread.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl -X POST https://sandbox.sellinpublic.com/api/v0/notifications/unread -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [
    "All items marked as read."
  ],
  "meta": {},
  "data": {}
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

