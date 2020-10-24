@extends('layouts.app')

@section('header')
@component('particals.jumbotron')
<h2 class="text-center oleo">Support this blog by buying me a coffee</h2>
@endcomponent
@endsection

@section('styles')
<style>
    .stripe-form input {
        border: 1px solid red !important;
    }

    .StripeElement {
        box-sizing: border-box;

        height: 40px;

        padding: 10px 12px;

        border: 2px solid rgb(206,212,218);
        border-radius: 4px;
        background-color: white;

        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
</style>
@endsection

@section('content')
<p class="text-center">Blogging isn't always easy. I try to write about my experiences on a regular basis but sometimes an
    extra dose of caffiene is needed to get the job done. As a reader, you can help me produce a higher quantity and
    quality of work with just a couple dollars for a cup of coffee.
</p>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="Jane Doe">

                <label for="name">Donation (CAD)</label>
                <input type="number" class="form-control" name="cost" id="cost" aria-describedby="helpId" value="5" min="0">

                <label>Credit Card</label>
                <div id="card-element" class="form-group"></div>

                <button id="card-button" class="btn btn-success">
                    Process Payment
                </button>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('{{env("STRIPE_KEY")}}');

    const elements = stripe.elements();
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    const cardElement = elements.create('card', {
        style: style
    });

    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');

    cardButton.addEventListener('click', async (e) => {
        stripe.createToken(cardElement).then(function(result) {
            if (result.error) {
                // Inform the customer that there was an error.
                alert(result.error.message);
            } else {
                // Send the token to your server.$.post('/charge',{
                $.post('/charge', {
                    "_token": "{{ csrf_token() }}",
                    'id': result.token.id,
                    'cost': document.getElementById('cost').value,
                }, function(response) {
                    if (response.status) {
                        window.location.replace('/coffee/success');
                    } else {
                        alert("Sorry, There was a problem with your card. Please check your card information and try again.")
                    }
                })
            }
        });

    });
</script>

@endsection

@include('particals.defaultSidebar')