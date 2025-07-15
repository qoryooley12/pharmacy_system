<?php
// session_start();
include_once '../auth/auth.php';

// Defensive: in case session not set
$permissions = $_SESSION['permissions'] ?? [];
?>
<div class="sidebar" id="sidebar">
  <div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
      <ul>

        <?php if (in_array("dashboard", $permissions)) : ?>
        <li class="active">
          <a href="index.html">
            <img src="../assets/img/icons/dashboard.svg" alt="img">
            <span>Dashboard</span>
          </a>
        </li>
        <?php endif; ?>

        <?php if (in_array("patients", $permissions)) : ?>
        <li class="submenu">
          <a href="javascript:void(0);">
            <img src="../assets/img/icons/users1.svg" alt="img">
            <span>Patients</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li><a href="../Admin/patient_add.php">Register Patient</a></li>
            <li><a href="../Admin/patient_grid.php">Patient grid</a></li>
            <li><a href="../Admin/patient-history.php">Patient History</a></li>
          </ul>
        </li>
        <?php endif; ?>

        <?php if (in_array("laboratory", $permissions)) : ?>
        <li class="submenu">
          <a href="javascript:void(0);">
            <i data-feather="activity"></i>
            <span>Laboratory</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li><a href="../Admin/lab-request-sheet.php">Lab Request Sheet</a></li>
            <li><a href="../Admin/lab-results-entry.php">Result Entry</a></li>
            <li><a href="../Admin/prescription.php">prescription drug</a></li>
          </ul>
        </li>
        <?php endif; ?>

        <?php if (in_array("pharmacy", $permissions)) : ?>
        <li class="submenu">
          <a href="javascript:void(0);">
            <i data-feather="shopping-bag"></i>
            <span>Pharmacy</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li><a href="medicine-list.html">Medicine List</a></li>
            <li><a href="add-medicine.html">Add Medicine</a></li>
            <li><a href="category-list.html">Categories</a></li>
            <li><a href="supplier-list.html">Suppliers</a></li>
          </ul>
        </li>
        <?php endif; ?>

        <?php if (in_array("sales", $permissions)) : ?>
        <li class="submenu">
          <a href="javascript:void(0);">
            <img src="../assets/img/icons/sales1.svg" alt="img">
            <span>Sales</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li><a href="sales-list.html">Sales List</a></li>
            <li><a href="pos.html">POS</a></li>
            <li><a href="new-sale.html">New Sale</a></li>
            <li><a href="sales-return-list.html">Sales Return</a></li>
          </ul>
        </li>
        <?php endif; ?>

        <?php if (in_array("purchases", $permissions)) : ?>
        <li class="submenu">
          <a href="javascript:void(0);">
            <img src="../assets/img/icons/purchase1.svg" alt="img">
            <span>Purchases</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li><a href="purchase-list.html">Purchase List</a></li>
            <li><a href="add-purchase.html">New Purchase</a></li>
          </ul>
        </li>
        <?php endif; ?>

        <?php if (in_array("inventory", $permissions)) : ?>
        <li class="submenu">
          <a href="javascript:void(0);">
            <img src="../assets/img/icons/expense1.svg" alt="img">
            <span>Inventory</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li><a href="stock-report.html">Stock Report</a></li>
            <li><a href="low-stock.html">Low Stock Alerts</a></li>
          </ul>
        </li>
        <?php endif; ?>

        <?php if (in_array("reports", $permissions)) : ?>
        <li class="submenu">
          <a href="javascript:void(0);">
            <img src="../assets/img/icons/time.svg" alt="img">
            <span>Reports</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li><a href="sales-report.html">Sales Report</a></li>
            <li><a href="purchase-report.html">Purchase Report</a></li>
            <li><a href="inventory-report.html">Inventory Report</a></li>
            <li><a href="lab-report-summary.html">Lab Reports</a></li>
          </ul>
        </li>
        <?php endif; ?>

        <?php if (in_array("settings", $permissions)) : ?>
        <li class="submenu">
          <a href="javascript:void(0);">
            <img src="../assets/img/icons/settings.svg" alt="img">
            <span>Settings</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li><a href="../Admin/users.php">Users</a></li>
            <li><a href="../Admin/user-permission.php">Roles and permissions</a></li>
            <li><a href="system-settings.html">System Settings</a></li>
          </ul>
        </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</div>
