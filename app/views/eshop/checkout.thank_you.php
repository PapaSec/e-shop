<?php $this->view("header", $data); ?>

<div class="container" style="text-align: center; padding: 80px 20px; max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 40px;">
        <i class="fa fa-check-circle fa-5x" style="color: #28a745; font-size: 60px; margin-bottom: 20px;"></i>
        <h1 class="mb-3">Thank you for shopping with us! 🎉</h1>
        <h4 class="text-muted mb-4">Your order was successfully placed</h4>
    </div>
    
    <div style="margin-bottom: 30px;">
         <h5 class="card-title mb-4">What would you like to do next?</h5>
        
        <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
            <button class="btn btn-warning" style="min-width: 180px; padding: 10px 20px;" onclick="window.location.href='<?= ROOT ?>shop'">
                <i class="fa fa-shopping-cart"></i> Continue Shopping
            </button>
            
            <button class="btn btn-warning" style="min-width: 180px; padding: 10px 20px;" onclick="window.location.href='<?= ROOT ?>profile'">
                <i class="fa fa-user"></i> View Your Orders
            </button>
        </div>
    </div>
</div>

<?php $this->view("footer", $data); ?>