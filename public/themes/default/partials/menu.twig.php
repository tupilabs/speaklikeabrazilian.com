<ul class='span12'>
	<li{% if(active == 'new')%} class='active'{% endif %}><a href="{{ URL.to('/new') }}">New</a></li>
	<li{% if(letter == 'a')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/a') }}">A</a></li>
	<li{% if(letter == 'b')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/b') }}">B</a></li>
	<li{% if(letter == 'c')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/c') }}">C</a></li>
	<li{% if(letter == 'd')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/d') }}">D</a></li>
	<li{% if(letter == 'e')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/e') }}">E</a></li>
	<li{% if(letter == 'f')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/f') }}">F</a></li>
	<li{% if(letter == 'g')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/g') }}">G</a></li>
	<li{% if(letter == 'h')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/h') }}">H</a></li>
	<li{% if(letter == 'i')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/i') }}">I</a></li>
	<li{% if(letter == 'j')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/j') }}">J</a></li>
	<li{% if(letter == 'k')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/k') }}">K</a></li>
	<li{% if(letter == 'l')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/l') }}">L</a></li>
	<li{% if(letter == 'm')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/m') }}">M</a></li>
	<li{% if(letter == 'n')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/n') }}">N</a></li>
	<li{% if(letter == 'o')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/o') }}">O</a></li>
	<li{% if(letter == 'p')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/p') }}">P</a></li>
	<li{% if(letter == 'q')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/q') }}">Q</a></li>
	<li{% if(letter == 'r')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/r') }}">R</a></li>
	<li{% if(letter == 's')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/s') }}">S</a></li>
	<li{% if(letter == 't')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/t') }}">T</a></li>
	<li{% if(letter == 'u')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/u') }}">U</a></li>
	<li{% if(letter == 'v')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/v') }}">V</a></li>
	<li{% if(letter == 'w')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/w') }}">W</a></li>
	<li{% if(letter == 'x')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/x') }}">X</a></li>
	<li{% if(letter == 'y')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/y') }}">Y</a></li>
	<li{% if(letter == 'z')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/z') }}">Z</a></li>
	<li{% if(letter == '0-9')%} class='active'{% endif %}><a href="{{ URL.to('expression/letter/0-9') }}">0 - 9</a></li>
	<li{% if(active == 'top')%} class='active'{% endif %}><a href="{{ URL.to('top') }}">Top</a></li>
	<li{% if(active == 'random')%} class='active'{% endif %}><a href="{{ URL.to('random') }}">Random</a></li>
</ul>
