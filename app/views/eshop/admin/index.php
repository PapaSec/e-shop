<?php $this->view("admin/header", $data); ?>

<?php $this->view("admin/sidebar", $data); ?>

<style>
    .dashboard-title {
        color: #2c3e50;
        font-weight: 600;
        margin: 2rem 0;
        border-bottom: 3px solid #3498db;
        padding-bottom: 0.5rem;
    }

    .stats-card {
        background: #fff;
        border-radius: 15px;
        padding: 1.5rem;
        margin: 1rem 0;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .card-icon {
        font-size: 2.5rem;
        color: #fff;
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: -15px;
        right: -15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .card-content h2 {
        font-size: 2.5rem;
        color: #2c3e50;
        margin: 1rem 0;
    }

    .card-content p {
        color: #7f8c8d;
        font-size: 1.1rem;
    }

    .card-hover {
        position: absolute;
        bottom: -50px;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.9);
        padding: 1rem;
        transition: bottom 0.3s ease;
    }

    .stats-card:hover .card-hover {
        bottom: 0;
    }

    /* Color Variants */
    .admin-card .card-icon {
        background: #3498db;
    }

    .customer-card .card-icon {
        background: #2ecc71;
    }

    .order-card .card-icon {
        background: #e74c3c;
    }

    .category-card .card-icon {
        background: #9b59b6;
    }

    .product-card .card-icon {
        background: #f1c40f;
    }

    .revenue-card .card-icon {
        background: #1abc9c;
    }

    .chart-container {
        background: #fff;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .chart-container h4 {
        color: #2c3e50;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }
</style>

<main class="container-fluid px-4">
    <h1 class="mt-4 dashboard-title">Dashboard Overview</h1>

    <div class="row stats-row">
        <!-- Admin Card -->
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="stats-card admin-card">
                <div class="card-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="card-content">
                    <h2><?= get_admin_count() ?></h2>
                    <p>Administrators</p>
                </div>
                <div class="card-hover">
                    <i class="fas fa-info-circle"></i>
                    <span>Users with system management privileges</span>
                </div>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="stats-card customer-card">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-content">
                    <h2><?= get_customer_count() ?></h2>
                    <p>Registered Customers</p>
                </div>
                <div class="card-hover">
                    <i class="fas fa-info-circle"></i>
                    <span>Active customer accounts</span>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="stats-card order-card">
                <div class="card-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-content">
                    <h2><?= get_order_count() ?></h2>
                    <p>Total Orders</p>
                </div>
                <div class="card-hover">
                    <i class="fas fa-info-circle"></i>
                    <span>Completed & pending orders</span>
                </div>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="stats-card category-card">
                <div class="card-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="card-content">
                    <h2><?= get_category_count() ?></h2>
                    <p>Product Categories</p>
                </div>
                <div class="card-hover">
                    <i class="fas fa-info-circle"></i>
                    <span>Active product categories</span>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="stats-card product-card">
                <div class="card-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <div class="card-content">
                    <h2><?= get_product_count() ?></h2>
                    <p>Total Products</p>
                </div>
                <div class="card-hover">
                    <i class="fas fa-info-circle"></i>
                    <span>Available in inventory</span>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="stats-card revenue-card">
                <div class="card-icon">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-content">
                    <h2>R <?= get_payment_total() ?></h2>
                    <p>Total Revenue</p>
                </div>
                <div class="card-hover">
                    <i class="fas fa-info-circle"></i>
                    <span>Lifetime generated revenue</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Visualization Section -->
    <div class="row mt-5">
        <div class="col-lg-8">
            <div class="chart-container">
                <h4><i class="fas fa-chart-line"></i> Sales Performance</h4>
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="chart-container">
                <h4><i class="fas fa-chart-pie"></i> Category Distribution</h4>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
</main>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sales Chart
        const salesCtx = document.getElementById('salesChart');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Monthly Revenue',
                    data: [10000, 15000, 12000, 18000, 20000, 25000],
                    borderColor: '#3498db',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(52,152,219,0.1)'
                }]
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Electronics', 'Clothing', 'Home', 'Sports'],
                datasets: [{
                    data: [30, 25, 20, 25],
                    backgroundColor: ['#3498db', '#2ecc71', '#9b59b6', '#f1c40f']
                }]
            }
        });
    });
</script>

<?php $this->view("admin/footer", $data); ?>