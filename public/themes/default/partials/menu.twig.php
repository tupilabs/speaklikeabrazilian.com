{% set active = Theme.get('active') %}
<ul class='span12'>
	<li{% if(active == 'new')%} class='active'{% endif %}><a href="{{ URL.to('/new') }}">{{ Lang.get('messages.new') }}</a></li>
	<li{% if(active == 'A')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/a') }}">A</a></li>
	<li{% if(active == 'B')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/b') }}">B</a></li>
	<li{% if(active == 'C')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/c') }}">C</a></li>
	<li{% if(active == 'D')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/d') }}">D</a></li>
	<li{% if(active == 'E')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/e') }}">E</a></li>
	<li{% if(active == 'F')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/f') }}">F</a></li>
	<li{% if(active == 'G')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/g') }}">G</a></li>
	<li{% if(active == 'H')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/h') }}">H</a></li>
	<li{% if(active == 'I')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/i') }}">I</a></li>
	<li{% if(active == 'J')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/j') }}">J</a></li>
	<li{% if(active == 'K')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/k') }}">K</a></li>
	<li{% if(active == 'L')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/l') }}">L</a></li>
	<li{% if(active == 'M')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/m') }}">M</a></li>
	<li{% if(active == 'N')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/n') }}">N</a></li>
	<li{% if(active == 'O')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/o') }}">O</a></li>
	<li{% if(active == 'P')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/p') }}">P</a></li>
	<li{% if(active == 'Q')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/q') }}">Q</a></li>
	<li{% if(active == 'R')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/r') }}">R</a></li>
	<li{% if(active == 'S')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/s') }}">S</a></li>
	<li{% if(active == 'T')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/t') }}">T</a></li>
	<li{% if(active == 'U')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/u') }}">U</a></li>
	<li{% if(active == 'V')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/v') }}">V</a></li>
	<li{% if(active == 'W')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/w') }}">W</a></li>
	<li{% if(active == 'X')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/x') }}">X</a></li>
	<li{% if(active == 'Y')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/y') }}">Y</a></li>
	<li{% if(active == 'Z')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/z') }}">Z</a></li>
	<li{% if(active == '0-9')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/0-9') }}">0 - 9</a></li>
	<li{% if(active == 'top')%} class='active'{% endif %}><a href="{{ URL.to('top') }}">{{ Lang.get('messages.top') }}</a></li>
	<li{% if(active == 'random')%} class='active'{% endif %}><a href="{{ URL.to('random') }}">{{ Lang.get('messages.random') }}</a></li>
</ul>
