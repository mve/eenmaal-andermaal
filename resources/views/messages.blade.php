@extends('layouts.app')

@section('content')

<div class="container pt-4">
	<h2>Berichten</h2>
	@if($convos)
	@if(Session()->has('message'))
	<div class="alert alert-success">
		{{ Session()->get('message') }}
	</div>
	@endif
	@if($errors->any())
	<div class="alert alert-danger">
		{{$errors->first()}}
	</div>
	@endif

	<div class="row">
		<div class="col-md-4 border">
			<div style="width:100%;overflow-y:auto;height:62vh;" class="ml-auto mr-auto mb-2">
				<table class="table table-hover mb-4 conversations-table">
					<tbody>
						@foreach($convos as $convo)
						<tr class="table-light" onclick="openConversation('conversation-{{$convo->conversation_id}}')">
							<td>
								<strong class="text-one-line">{{$convo->auction_title}}</strong>
								@if(end($convo->messages)->is_read == 1)
								<div class="text-one-line">{{end($convo->messages)->message}}</div>
								@else
								<strong>
									<div class="text-one-line">{{end($convo->messages)->message}}</div>
								</strong>
								@endif

								@if(date('Y', strtotime(end($convo->messages)->created_at)) >= now()->year)
								<div class="text-right"><i>{{date('H:i d-m', strtotime(end($convo->messages)->created_at))}}</i></div>
								@else
								<div class="text-right"><i>{{date('H:i d-m-Y', strtotime(end($convo->messages)->created_at))}}</i></div>
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-8 border">
			@foreach($convos as $convo)
			<div class="conversation d-none mb-2" id="conversation-{{$convo->conversation_id}}">
				<a href="{{ route('auctions.show', $convo->auction_id) }}" class="text-decoration-none">
					<div class="border p-3 pb-1">
						<h5>{{$convo->auction_title}}</h5>
					</div>
				</a>
				<div class="overflow-auto">
					<!--  min-height: 33vh;;max-height: 33vh; -->
					<div class="chat-container overflow-auto" style="height:55vh;">
						@foreach($convo->messages as $msg)
						<div class="m-2">
							@if($msg->user_id == Session::get('user')->id)
							<div class="messagebox border p-2 offset-6" style="max-width: 50%">
								@else
								<div class="messagebox border p-2" style="max-width: 50%">
									@endif
									<span>{{$msg->message}}</span>
									@if(date('Y', strtotime($msg->created_at)) >= now()->year)
									<div class="text-right"><i>{{date('H:i d-m', strtotime($msg->created_at))}}</i></div>
									@else
									<div class="text-right"><i>{{date('H:i d-m-Y', strtotime($msg->created_at))}}</i></div>
									@endif
								</div>
							</div>
							@endforeach
						</div>
					</div>
					<form method="POST" action="{{ route('messages.send') }}">
						@csrf
						<div>
							<input type="hidden" name="auctionId" value="{{$convo->auction_id}}">
							<input type="hidden" name="conversationId" value="{{$convo->conversation_id}}">
							<button class="btn btn-large btn-primary float-right" type="submit">Verstuur</button>
							<span class="d-block overflow-hidden pr-1"><input name="message" type="text" class="form-control float-left"></span>
						</div>
					</form>
				</div>
				@endforeach
			</div>
		</div>

		@else
		<p class="py-4">U heeft nog geen berichten ontvangen of verstuurd</p>
		@endif
	</div>
</div>

<script>
	function openConversation(elementId) {
		closeAllConversations();

		var el = document.getElementById(elementId);

		if (el) {
			if (el.classList.contains('d-none')) {
				el.classList.remove('d-none');
			} else {
				el.classList.add('d-none');
			}
			var chatElement = el.querySelector(".chat-container");
			chatElement.scrollTop = chatElement.offsetHeight;
			if (window.innerWidth <= 767) {
				const y = chatElement.closest(".conversation").getBoundingClientRect().top + window.scrollY;
				window.scroll({
					top: y,
					behavior: 'smooth'
				});
			}
		}
	}

	function closeAllConversations() {
		var convos = document.querySelectorAll('.conversation');
		convos.forEach(convo => {
			if (!convo.classList.contains('d-none')) {
				convo.classList.add('d-none');
			}
		})
	}

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = () => {
		if (this.readyState == 4 && this.status == 200) {
			console.log('Versturen geslaagd!');
		} else {
			console.log('Versturen mislukt!');
		}
	};
	xhttp.open("GET", "{{route('messages.read')}}" + (maxId + 1), true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();

	@if(isset($_GET["conversation"]))
		openConversation("conversation-{{$_GET["conversation "]}}");
	@endif
</script>

@endsection