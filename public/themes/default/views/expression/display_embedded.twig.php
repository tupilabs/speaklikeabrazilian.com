<section id='main' style="top: 0; left: 0;">
	<div class='container-fluid'>
		<div class="row-fluid">
			<div class="" id="embed">
				<div class='expression'>
					<h2 class="text">{{ definition.expression.text }}</h2>
					<div class="description">
					{{ definition.description }}
					</div>
					<h5>Sample sentences</h5>
					<div class="examples">
					{{ definition.example }}
					</div>
					<br/>
					<div class="authorship">
						<strong>Author:</strong> <span class="author box">{{ definition.expression.contributor }}</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type='text/javascript'>
templatecallback = function() {
	base_url = '{{ URL.to("/") }}';
}
</script>