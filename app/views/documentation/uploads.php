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
                    <h2>Uploads</h2>
                    <p>There are three private endpoints for uploads that require a Pro account.</p>
                    <p>The example cURL calls use an example file. The example file can be downloaded here: <a href="/documentation/download">demo.png</a></p>

					<hr>
					<h3>POST /upload</h3>
					<p>Private endpoint. Initialize the upload process and receive the id need to upload a file.</p>

                    <h4>Request body</h4>
                    <p><strong>file_type</strong>: string<br>
                    The type of file being uploaded. Should be one of the following values: image</p>
                    <p><strong>original_name</strong>: string<br>
                    The original name of the file, including extension: example.png</p>
                    <p><strong>original_extension</strong>: string<br>
                    The original extension of the file, including the period. Should be one of the following: .jpg, .png</p>
                    <p><strong>upload_type</strong>: string<br>
                    The purpose of the file being uploaded. Should be one of the following values: profile</p>
                    <p><strong>total_bytes</strong>: integer<br>
                    The total bytes of the file to be uploaded.</p>


                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl -X POST https://sandbox.sellinpublic.com/api/v0/upload -u "demo:sip_api_sand_01234demo56789_key" -d "file_type=image" -d "original_name=example.png" -d "original_extension=.png" -d "upload_type=profile" -d "total_bytes=9599"</code>
                    </div>

                    <p>Below is the expected result from that cURL call. The `id` is the most important part of the response. The `expired_at` value tells you how much time you have to fully upload the file. Once the `expired_at` time has been reached, you will no longer be able to upload the file. </p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {},
  "data": {
    "id": 2,
    "user_id": 1,
    "status": "created",
    "expired_at": "2024-03-24T07:21:04+00:00",
    "media": []
  }
}
</pre>
                    </div>


					<hr>
					<h3>POST /upload/{upload_id}/chunked</h3>
					<p>Private endpoint. Upload a file or part of a file.</p>


                    <h4>URL params</h4>
                    <p><strong>upload_id</strong>: integer<br>
                    The id of the upload (this is the id returned by the POST /upload call above).</p>


                    <h4>Request body</h4>
                    <p><strong>index</strong>: integer<br>
                    The number of times this endpoint has been called for this `upload_id` starting with 0. Each time a chunk is uploaded, increase the index by 1. </p>
                    <p><strong>chunk</strong>: binary<br>
                    The file data. This endpoint can be called multiple times with chunks of the file or it can be called once with the entire data.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted. It uses the demo.png file mentioned at the top of this page.</p>
                    <div class="code">
                        <code>curl -X POST https://sandbox.sellinpublic.com/api/v0/upload/2/chunked -u "demo:sip_api_sand_01234demo56789_key" -F "index=0" -F chunk=@demo.png</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {},
  "data": {}
}
</pre>
                    </div>


					<hr>
					<h3>POST /upload/{upload_id}/completed</h3>
					<p>Private endpoint. Mark the upload as completed. The response will include the media id which can be used in other calls (like updating the profile image of an account).</p>


                    <h4>URL params</h4>
                    <p><strong>upload_id</strong>: integer<br>
                    The id of the upload (this is the id returned by the POST /upload call above).</p>


                    <h4>Request body</h4>
                    <p><strong>total_chunks</strong>: integer<br>
                    The total times the previous chunked call has been made. If it was only called once, then the `total_chunks` will be 1.</p>


                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl -X POST https://sandbox.sellinpublic.com/api/v0/upload/2/completed -u "demo:sip_api_sand_01234demo56789_key" -d "total_chunks=1"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {},
  "data": {
    "id": 2,
    "user_id": 1,
    "status": "completed",
    "expired_at": "2024-03-24T07:21:04+00:00",
    "media": [
      {
        "id": 2,
        "user_id": 1,
        "url_location": "https://sandbox.sellinpublic.com/media/100/profile_2.png",
        "type": "profile"
      }
    ]
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

