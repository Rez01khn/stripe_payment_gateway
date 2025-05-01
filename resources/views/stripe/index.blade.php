<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Payment</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.05);
            border-radius: 16px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <div class="card-header bg-white border-bottom-0">
                        <h4 class="mb-0">Make Payment</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="bg-light p-3 rounded">
                            <h6 class="mb-3">Order Summary</h6>
                            <div class="d-flex justify-content-between small mb-1">
                                <span>Subtotal</span> <span>$190.00</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-1">
                                <span>Shipping</span> <span>$20.00</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-1">
                                <span>Coupon (NEWYEAR)</span> <span class="text-danger">-$10.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold mb-3">
                                <span>Total</span> <span class="text-dark">$200.00</span>
                            </div>
                            <form method="POST" action="{{ route('stripe.payment') }}" id="stripe-form">
                                @csrf
                                <input type="hidden" name="price" value="200">
                                <input type="hidden" name="stripeToken" id="stripe-token" value="">
                                <div id="card-element" class="form-control"> </div>
                                <button class="btn btn-primary w-100 mt-2" type="button"
                                    onclick="createToken()">Submit</button>
                            </form>

                            <!-- Stripe Payment Button Placeholder -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<script src="https://js.stripe.com/basil/stripe.js"></script>

<script type="text/javascript">
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');

    var elements = stripe.elements()
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    function createToken() {
        stripe.createToken(cardElement).then(function(result) {
            console.log(result);
            if (result.token) {
                document.getElementById("stripe-token").value = result.token.id;
                document.getElementById("stripe-form").submit();
            }
        });
    }
</script>

</html>
