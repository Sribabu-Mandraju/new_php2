<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Masked Intel</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script> <!-- Add this line -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Geometric Background Shapes -->
    <div class="geometric-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Admin Navigation -->
    <nav class="navbar">
        <div class="logo">
            <div class="logo-wrapper">
                <img src="logo.png" alt="Masked Intel Logo" class="logo-icon">
            </div>
            <span>Masked Intel</span>
        </div>
        <div class="admin-nav">
            <a href="#" class="nav-link active" onclick="showSection('dashboard')">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="#" class="nav-link" onclick="showSection('users')">
                <i class="fas fa-users"></i> Users
            </a>
            <a href="#" class="nav-link" onclick="showSection('messages')">
                <i class="fas fa-envelope"></i> Messages
            </a>
            <a href="index.php" class="nav-btn logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>

    <div class="admin-container">
        <!-- Dashboard Section -->
        <section id="dashboard" class="admin-section dashboard active">
            <div class="dashboard-horizontal">
                <!-- Welcome Header -->
                <div class="welcome-header">
                    <h1>Welcome back, <span class="admin-name">John Admin</span>!</h1>
                    <p class="last-login">Last login: March 20, 2024 at 14:30</p>
                </div>

                <!-- Stats Section -->
                <div class="dashboard-stats">
                    <div class="stat-card">
                        <i class="fas fa-users"></i>
                        <div class="stat-info">
                            <h3>Total Users</h3>
                            <p class="stat-number">1,245</p>
                            <span class="stat-trend positive">+12% this week</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-envelope"></i>
                        <div class="stat-info">
                            <h3>Messages</h3>
                            <p class="stat-number">342</p>
                            <span class="stat-trend negative">-5% this week</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Section -->
                <div class="quick-actions">
                    <h2>Quick Actions</h2>
                    <div class="action-buttons">
                        <button class="quick-action-btn add-user-btn" onclick="openAddUserModal()">
                            <i class="fas fa-user-plus"></i>
                            <span>Add New User</span>
                        </button>
                        <button class="quick-action-btn view-messages-btn" onclick="showSection('messages')">
                            <i class="fas fa-envelope-open"></i>
                            <span>View Messages</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Users Section -->
        <section id="users" class="admin-section user-management">
            <div class="users-header">
                <h2>Manage Users</h2>
                <button class="add-user-btn" onclick="openAddUserModal()">Add New User</button>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <input type="text" id="userSearch" placeholder="Search users..." oninput="filterUsers()">
            </div>

            <!-- Users Table -->
            <div class="users-table-container">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <!-- User rows will be dynamically populated -->
                    </tbody>
                </table>
            </div>

            <!-- Add User Modal -->
            <div class="modal" id="addUserModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Add/Edit User</h3>
                        <button class="close-modal" onclick="closeModal('addUserModal')">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="addUserForm" onsubmit="addUser(event)">
                            <div class="form-group">
                                <label for="userName">Name</label>
                                <input type="text" id="userName" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="userEmail">Email</label>
                                <input type="email" id="userEmail" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="userRole">Role</label>
                                <select id="userRole" name="role" required>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="save-btn">Save</button>
                                <button type="button" class="cancel-btn" onclick="closeModal('addUserModal')">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Messages Section -->
        <section id="messages" class="admin-section messages-section">
          <div class="messages-header">
            <h2>Messages</h2>
          </div>

          <!-- Messages Table -->
          <div class="messages-table-container">
            <table class="messages-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Inquiry Type</th>
                  <th>Message</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="messagesTableBody">
                <!-- Messages will be dynamically populated -->
              </tbody>
            </table>
          </div>
        </section>
    </div>

    <!-- Enhanced Edit User Modal -->
    <div class="modal" id="editUserModal" role="dialog" aria-labelledby="editUserModalTitle" aria-modal="true">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="editUserModalTitle"><i class="fas fa-user-edit" aria-hidden="true"></i> Edit User</h3>
                <button class="close-modal" onclick="closeModal('editUserModal')" aria-label="Close modal">
                    <i class="fas fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="edit-user-form" onsubmit="return saveUserChanges(event)" novalidate>
                    <div class="form-grid" role="group">
                        <div class="form-section" role="group" aria-labelledby="basicInfoTitle">
                            <div id="basicInfoTitle" class="form-section-title">Basic Information</div>
                            <div class="field-group">
                                <div class="form-group">
                                    <label for="editUserName" class="required-field">
                                        <i class="fas fa-user" aria-hidden="true"></i>
                                        Full Name
                                        <span class="sr-only">(required)</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="editUserName" 
                                        name="name" 
                                        required 
                                        aria-required="true"
                                        aria-describedby="nameError"
                                        placeholder="Enter full name"
                                    >
                                    <div id="nameError" class="validation-message" role="alert"></div>
                                </div>
                                <div class="form-group">
                                    <label for="editUserEmail" class="required-field">
                                        <i class="fas fa-envelope" aria-hidden="true"></i>
                                        Email
                                        <span class="sr-only">(required)</span>
                                    </label>
                                    <input 
                                        type="email" 
                                        id="editUserEmail" 
                                        name="email" 
                                        required 
                                        aria-required="true"
                                        aria-describedby="emailError"
                                        placeholder="Enter email address"
                                    >
                                    <div id="emailError" class="validation-message" role="alert"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section" role="group" aria-labelledby="roleStatusTitle">
                            <div id="roleStatusTitle" class="form-section-title">Role & Status</div>
                            <div class="field-group">
                                <div class="form-group">
                                    <label for="editUserRole" class="required-field">
                                        <i class="fas fa-user-tag" aria-hidden="true"></i>
                                        Role
                                        <span class="sr-only">(required)</span>
                                    </label>
                                    <select 
                                        id="editUserRole" 
                                        name="role" 
                                        required 
                                        aria-required="true"
                                        aria-describedby="roleError"
                                    >
                                        <option value="">Select Role</option>
                                        <option value="user">Standard User</option>
                                        <option value="admin">Administrator</option>
                                        <option value="moderator">Moderator</option>
                                        <option value="analyst">Analyst</option>
                                    </select>
                                    <div id="roleError" class="validation-message" role="alert"></div>
                                </div>
                                <div class="form-group">
                                    <label for="editUserStatus" class="required-field">
                                        <i class="fas fa-toggle-on" aria-hidden="true"></i>
                                        Status
                                        <span class="sr-only">(required)</span>
                                    </label>
                                    <select 
                                        id="editUserStatus" 
                                        name="status" 
                                        required 
                                        aria-required="true"
                                        aria-describedby="statusError"
                                    >
                                        <option value="">Select Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="pending">Pending Activation</option>
                                    </select>
                                    <div id="statusError" class="validation-message" role="alert"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section" role="group" aria-labelledby="contactTitle">
                            <div id="contactTitle" class="form-section-title">Contact Details</div>
                            <div class="field-group">
                                <div class="form-group">
                                    <label for="editUserDepartment" class="required-field">
                                        <i class="fas fa-building" aria-hidden="true"></i>
                                        Department
                                        <span class="sr-only">(required)</span>
                                    </label>
                                    <select 
                                        id="editUserDepartment" 
                                        name="department" 
                                        required 
                                        aria-required="true"
                                        aria-describedby="departmentError"
                                    >
                                        <option value="">Select Department</option>
                                        <option value="IT">IT Department</option>
                                        <option value="HR">Human Resources</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Sales">Sales</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Operations">Operations</option>
                                        <option value="Support">Support</option>
                                    </select>
                                    <div id="departmentError" class="validation-message" role="alert"></div>
                                </div>
                                <div class="form-group">
                                    <label for="editUserPhone" class="required-field">
                                        <i class="fas fa-phone" aria-hidden="true"></i>
                                        Phone Number
                                        <span class="sr-only">(required)</span>
                                    </label>
                                    <input 
                                        type="tel" 
                                        id="editUserPhone" 
                                        name="phone" 
                                        required 
                                        aria-required="true"
                                        aria-describedby="phoneError"
                                        placeholder="Enter phone number"
                                    >
                                    <div id="phoneError" class="validation-message" role="alert"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section" role="group" aria-labelledby="additionalTitle">
                            <div id="additionalTitle" class="form-section-title">Additional Information</div>
                            <div class="form-group full-width">
                                <label for="editUserNotes">
                                    <i class="fas fa-sticky-note" aria-hidden="true"></i>
                                    Notes
                                </label>
                                <textarea 
                                    id="editUserNotes" 
                                    name="notes" 
                                    rows="3"
                                    aria-describedby="notesHint"
                                    placeholder="Enter any additional notes"
                                ></textarea>
                                <div id="notesHint" class="hint-text">Optional: Add any relevant notes about the user</div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button 
                                type="button" 
                                class="cancel-btn" 
                                onclick="closeModal('editUserModal')"
                                aria-label="Cancel editing user"
                            >
                                <i class="fas fa-times" aria-hidden="true"></i>
                                Cancel
                            </button>
                            <button 
                                type="submit" 
                                class="save-btn"
                                aria-label="Save user changes"
                            >
                                <i class="fas fa-save" aria-hidden="true"></i>
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal" id="changePasswordModal">
        <div class="modal-content">
            <h3>Change Password</h3>
            <form id="changePasswordForm" onsubmit="return changePassword(event)">
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="currentPassword" required>
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="newPassword" required>
                </div>
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirmPassword" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="save-btn">Change Password</button>
                    <button type="button" class="cancel-btn" onclick="closeModal('changePasswordModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Custom Alert Box -->
    <div id="customAlert" class="custom-alert" style="display: none;">
        <div class="alert-content">
            <i class="fas fa-sync-alt fa-spin"></i>
            <p>Refreshing data...</p>
        </div>
    </div>

    <!-- Add JavaScript for functionality -->
    <script src="script.js"></script>

    <style>
        /* Add styles for bulk actions */
        .bulk-actions {
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            margin-top: 1rem;
        }

        .delete-selected-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .delete-selected-btn:hover {
            background: #c82333;
        }

        .user-select {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        /* Center all content in table cells */
        .users-table td,
        .users-table th {
            text-align: center !important;
            vertical-align: middle !important;
        }

        /* Center the user cell content */
        .user-cell {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            text-align: center;
        }

        .user-cell-info {
            text-align: center;
        }

        .user-name,
        .user-email {
            display: block;
            text-align: center;
        }

        /* Center the table actions */
        .table-actions {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        /* Center role and status badges */
        .role-badge,
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        /* Custom Alert Styles */
        .custom-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.9);
            border-left: 4px solid #4a90e2;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
        }

        .alert-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .alert-content i {
            font-size: 1.2rem;
            color: #4a90e2;
        }

        .alert-content p {
            margin: 0;
            font-size: 0.95rem;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .custom-alert.hide {
            animation: slideOut 0.3s ease-in forwards;
        }

        /* Add User Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            position: relative;
            background: #1a1a1a;
            margin: 2rem auto;
            padding: 2rem;
            width: 90%;
            max-width: 600px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-header h3 {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }

        .close-modal {
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .form-grid {
            display: grid;
            gap: 1.5rem;
        }

        .form-section {
            background: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 10px;
        }

        .form-section-title {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: #4a90e2;
        }

        .field-group {
            display: grid;
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group input,
        .form-group select {
            padding: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .required-field::after {
            content: '*';
            color: #dc3545;
            margin-left: 0.25rem;
        }
    </style>
</body>
</html>