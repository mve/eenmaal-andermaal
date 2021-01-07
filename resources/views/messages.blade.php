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
		<div class="col-md-4">
			<table class="table table-hover mb-4">
				<tbody>
					@foreach($convos as $convo)
					<tr class="table-light" onclick="openConversation('conversation-{{$convo->conversation_id}}')">
						<td>
							<strong class="text-one-line">{{$convo->auction_title}}</strong>
							<div class="text-one-line">{{end($convo->messages)->message}}</div>
							@if(date('Y', strtotime(end($convo->messages)->created_at)) >= now()->year)
							<div class="text-right"><i>{{date('d-m H:i', strtotime(end($convo->messages)->created_at))}}</i></div>
							@else
							<div class="text-right"><i>{{date('d-m-Y H:i', strtotime(end($convo->messages)->created_at))}}</i></div>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-8">
			@foreach($convos as $convo)
			<div class="conversation d-none mb-2" id="conversation-{{$convo->conversation_id}}">
				<a href="{{ route('auctions.show', $convo->auction_id) }}" class="text-decoration-none">
					<div class="border p-3 pb-1">
						<h5>{{$convo->auction_title}}</h5>
					</div>
				</a>
				<div class="overflow-auto">
					<div class="chat-container overflow-auto" style="min-height: 33vh; max-height: 33vh;">
						@foreach($convo->messages as $msg)
						<div class="m-2">
							@if($msg->user_id == Session::get('user')->id)
							<div class="messagebox border p-2 offset-6" style="max-width: 50%">
								@else
								<div class="messagebox border p-2" style="max-width: 50%">
									@endif
									<span>{{$msg->message}}</span>
									@if(date('Y', strtotime($msg->created_at)) >= now()->year)
									<div class="text-right"><i>{{date('d-m H:i', strtotime($msg->created_at))}}</i></div>
									@else
									<div class="text-right"><i>{{date('d-m-Y H:i', strtotime($msg->created_at))}}</i></div>
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

		if (el.classList.contains('d-none')) {
			el.classList.remove('d-none');
		} else {
			el.classList.add('d-none');
		}
		var chatElement = el.querySelector(".chat-container");
        chatElement.scrollTop = chatElement.offsetHeight;
        if(window.innerWidth <= 767){
            const y = chatElement.closest(".conversation").getBoundingClientRect().top + window.scrollY;
            window.scroll({
                top: y,
                behavior: 'smooth'
            });
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

	@if(isset($_GET["conversation"]))
        openConversation("conversation-{{$_GET["conversation"]}}");
    @endif
</script>

@endsection
