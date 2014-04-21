			<div class='col-xs-2' style='padding-top: 20px;'>
            	<ul class="nav nav-pills nav-stacked">
                    <li><a href='{{ URL.to('/moderators') }}'>Moderators Home</a></li>
                    <li><a href='{{ URL.to('/moderators/pendingExpressions') }}'>Pending expressions</a></li>
                    <li><a href='{{ URL.to('/moderators/pendingVideos') }}'>Pending videos</a></li>
                    <li><a href='{{ URL.to('/moderators/pendingPictures') }}'>Pending pictures</a></li>
                    <li><a href="{{ URL.to('/user/logout') }}">Logout</a>
                </ul>
            </div>