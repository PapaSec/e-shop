<?php $this->view("admin/header", $data); ?>

<?php $this->view("admin/sidebar", $data); ?>

<div class="admin-dashboard">
    <div class="container-fluid py-4">
        <h2 class="text-white mb-4 text-center" style="background: linear-gradient(90deg, #4a90e2, #50e3c2); padding: 10px; border-radius: 5px;">Admin Dashboard</h2>

        <div class="row">
            <!-- Admin Count Card -->
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="dashboard-card bg-primary text-white">
                    <div class="card-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="card-content">
                        <h3 class="card-value"><?= get_admin_count() ?></h3>
                        <p class="card-label">Total Admins</p>
                    </div>
                </div>
            </div>

            <!-- Customer Count Card -->
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="dashboard-card bg-success text-white">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-content">
                        <h3 class="card-value"><?= get_customer_count() ?></h3>
                        <p class="card-label">Total Customers</p>
                    </div>
                </div>
            </div>

            <!-- Order Count Card -->
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="dashboard-card bg-info text-white">
                    <div class="card-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="card-content">
                        <h3 class="card-value"><?= get_order_count() ?></h3>
                        <p class="card-label">Total Orders</p>
                    </div>
                </div>
            </div>

            <!-- Category Count Card -->
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="dashboard-card bg-warning text-dark">
                    <div class="card-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="card-content">
                        <h3 class="card-value"><?= get_category_count() ?></h3>
                        <p class="card-label">Total Categories</p>
                    </div>
                </div>
            </div>

            <!-- Product Count Card -->
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="dashboard-card bg-danger text-white">
                    <div class="card-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div class="card-content">
                        <h3 class="card-value"><?= get_product_count() ?></h3>
                        <p class="card-label">Total Products</p>
                    </div>
                </div>
            </div>

            <!-- Payment Total Card -->
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="dashboard-card bg-secondary text-white">
                    <div class="card-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="card-content">
                        <h3 class="card-value">R <?= number_format(get_payment_total(), 2) ?></h3>
                        <p class="card-label">Total Payments</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-dashboard {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: calc(100vh - 120px);
        padding-top: 20px;
    }

    .dashboard-card {
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        overflow: hidden;
        position: relative;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .dashboard-card.bg-primary {
        background: linear-gradient(45deg, #4a90e2, #50e3c2);
    }

    .dashboard-card.bg-success {
        background: linear-gradient(45deg, #28a745, #34ce57);
    }

    .dashboard-card.bg-info {
        background: linear-gradient(45deg, #17a2b8, #1abc9c);
    }

    .dashboard-card.bg-warning {
        background: linear-gradient(45deg, #ffc107, #ffca2c);
    }

    .dashboard-card.bg-danger {
        background: linear-gradient(45deg, #dc3545, #e4606d);
    }

    .dashboard-card.bg-secondary {
        background: linear-gradient(45deg, #6c757d, #868e96);
    }

    .card-icon {
        position: absolute;
        top: 20px;
        left: 20px;
        font-size: 2rem;
        opacity: 0.7;
    }

    .card-content {
        padding: 20px 20px 20px 60px;
        text-align: right;
    }

    .card-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        line-height: 1;
    }

    .card-label {
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 5px 0 0;
        font-weight: 500;
    }

    @media (max-width: 768px) {

        .col-md-4,
        .col-sm-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .card-content {
            padding-left: 20px;
        }

        .card-icon {
            position: static;
            margin-bottom: 10px;
        }
    }
</style>

<?php $this->view("admin/footer", $data); ?>