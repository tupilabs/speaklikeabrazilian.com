			<div class='col-xs-2' style='padding-top: 20px;'>
            	<ul class="nav nav-pills nav-stacked">
                    <li><a href='{{ URL.action('ModeratorController@getModerators') }}'>Moderators Home</a></li>
                    <li><a href='{{ URL.action('ModeratorController@getPendingExpressions') }}'>Pending expressions</a></li>
                    <li><a href='{{ URL.action('ModeratorController@getPendingVideos') }}'>Pending videos</a></li>
                    <li><a href='{{ URL.action('ModeratorController@getPendingPictures') }}'>Pending pictures</a></li>
                    <li><a href='{{ URL.action('ModeratorController@getProfile') }}'>Profile</a>
                    <li><a href="{{ URL.action('UserController@getLogout') }}">Logout</a>
                </ul>
            </div>