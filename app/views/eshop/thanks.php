<?php $this->view("header", $data); ?>

<?php $this->view("slider", $data); ?>


<section>
    <div class="container">
        <di class="row">
            <div style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
            padding: 3rem; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            text-align: center;
            max-width: 800px;
            margin: 2rem auto;
            border-left: 5px solid #4e73df;">
                <h1 style="color: #2d3748; 
               font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
               font-weight: 600;
               margin-bottom: 1rem;">
                    Thank You for Shopping With Us! 💙
                </h1>
                <p style="color: #4a5568; 
              font-size: 1.1rem;
              line-height: 1.6;">
                    We appreciate your business! Your order is being processed and you'll receive a confirmation shortly.
                </p>
                <div style="margin-top: 2rem;">
                    <a href="<?= ROOT ?>shop" style="background: #4e73df;
                          color: white;
                          padding: 12px 24px;
                          border-radius: 50px;
                          text-decoration: none;
                          font-weight: 500;
                          display: inline-block;
                          transition: all 0.3s ease;">Continue Shopping</a>
                </div>
            </div>
    </div>
    </div>
</section>

<?php $this->view("footer", $data); ?>