<div align="center">
    <h1>User manager</h1>
    ⚠️ This project is a work in progress. Many features are still under development and not yet fully implemented.
    <p>
        <a href="https://usermanager.davidfabian.hu/">Live Demo</a>
    </p>
</div>

### Table of content
<ol>
    <li>
        <a href="#about-the-project">About the project</a>
        <ul>
            <li><a href="#built-with">Built with</a></li>
        </ul>
    </li>
    <li>
        <a href="#getting-started">Getting Started</a>
        <ul>
            <li><a href="#prerequisites">Prerequisites</a></li>
            <li><a href="#installation">Installation</a></li>
        </ul>
    </li>
    <li>
        <a href="#menu">Menu map</a>
        <ul>
            <li><a href="#user-interface">User</a></li>
            <li><a href="#admin-interface">Admin</a></li>
        </ul>
    </li>
    <li><a href="#menu-details">Menu details</a></li>
</ol>

## About The Project
<div id="about-the-project">
    This project is a Laravel-Blade based User Manager system tailored to meet the needs of a local hospital's internal user registration and management workflows.<br/><br/>
    The application offers an Admin Interface for configuring authorizations and sub-authorizations, managing departments and locations, directly edit user-related requests (create/edit/delete), and directly managing users and local accounts. Admins can also configure authentication levels and general settings such as application name, logo, technical email address     for notifications, and ISPConfig SOAP API credentials. Additionally, they can rename field labels (e.g., departmentNumber) and define display names and required LDAP groups for each authorization level.<br/><br/>
    The System User Interface allows authorized users to submit requests to create, edit, or delete user accounts. If ISPConfig integration is enabled, system users with the appropriate authorization can directly manage email distribution lists. Users can also search for existing users, requests, and (if configured) distribution lists.
</div>

### Built with

<div id="built-with">
    
[![Laravel][Laravel-logo]][Laravel-url]</br>
[![Livewire][Livewire-logo]][Livewire-url]</br>
[![Tailwind][Tailwindcss-logo]][Tailwindcss-url]</br>
[![MySQL][MySQL-logo]][MySQL-url]

</div>

## Getting Started
<div id="getting-started">
    
### Prerequisites
<div id="prerequisites"></div>

<li>Laravel 12 <a href="https://laravel.com/docs/12.x/installation">Installation</a></li>
<li>Database <a href="https://laravel.com/docs/12.x/database#introduction">List</a></li>
<li>Composer <a href="https://getcomposer.org/download/">Installation</a></li>
<li>NPM <a href="https://docs.npmjs.com/downloading-and-installing-node-js-and-npm">Installation</a></li>
<li>PHP version ">= 8.2.0"</li>

### Installation
<div id="installation"></div>

1. Clone the repository
   ```sh
   git clone https://github.com/Dazannah/usermanager.git
   ```

2. Enable LDAP in Php
   ```sh
    sudo apt-get install php-ldap
   ```
   Enable LDAP in php.ini
   ```
    extension=ldap
   ```
  
3. Install dependencies
   ```sh
   composer install
   npm install
   npm run build
   ```
   
4. Set up .env</br>
   Copy .env.example to .env</br>

   Left APP_INSTALLED set to false and APP_IS_LOCAL_ACCOUNT_ENABLED on true if you want to create a sysAdmin local account on start. You can also do it later.</br>
   Fill out the DB section</br></br>
   
   If you want to use LDAP authentication, fill out the LDAP section.<br>
   You can test LDAP connection with:
   ```
   php artisan ldap:test
   ```

5. Generate application key</br>
    ```
    php artisan key:generate
    ```
    
6. Run migration
    ```
    php artisan migrate
    ```

## Menu
<div id="menu"></div>

#### The menu content depends on the authorization level, the below is with every privilige.

### User interface
<div id="user-interface"></div>
<ul>
    <li>Recap</li>
    <li><strike>New user</strike></li>
    <li><strike>New distribution list</strike></li>
    <li><strike>Requests</strike></li>
        <ul>
            <li><strike>Pending approvals</strike></li>
            <li><strike>Approved requests</strike></li>
        </ul>
    <li><strike>Users</strike></li>
    <li><strike>Distribution lists</strike></li>
    <li>Personal menu</li>
        <ul>
            <li>Profile</li>
            <li>System admin interface</li>
            <li>Log out</li>
        </ul>
</ul>

### Admin interface
<div id="user-interface"></div>
<ul>
    <li>Admin Recap</li>
    <li>Authorizations</li>
        <ul>
            <li>Add column</li>
            <li>Add authorization</li>
            <li>Add sub authorization</li>
        </ul>
    <li>Departments</li>
        <ul>
            <li>Add department</li>
        </ul>
    <li>Locations</li>
        <ul>
            <li>Add location</li>
        </ul>
    <li><strike>Requests</strike></li>
    <li><strike>Users</strike></li>
    <li>Local accounts</li>
        <ul>
            <li>Add local account</li>
        </ul>
    <li>Settings</li>
        <ul>
            <li>General</li>
            <li>Texts</li>
            <li>Authorization levels</li>
        </ul>
    <li>Personal menu</li>
        <ul>
            <li>Profile</li>
            <li>System user interface</li>
            <li>Log out</li>
        </ul>
</ul>

## Menu details
<div id="menu-details"></div>

### User interface details

#### Recap

System users can view and search their most recent requests here. The section is divided into three parts:
<ul>
    <li>Requests for </li>
    <li>Latest (all statuses): Displays the newest requests, regardless of status, with the most recent ones shown first.</li>
    <li>Latest Completed: Shows only recently completed requests.</li>
    <li>Latest In Progress: Lists requests that are currently being processed.</li>
</ul>

#### <strike>New user</strike>

System users can submit requests to create a new user account.</br>
The form includes the following fields:
<ul>
    <li>Enter the user's full name</li>
    <li>(Optional) Mark as a technical user</li>
    <li>(Optional) Enter registration number for internal use (can be disabled in settings)</li>
    <li>Select one or more departments</li>
    <li>(To clarify: should department leaders be auto-filled? What if multiple departments are selected?) Department leader</li>
    <li>(To clarify: should job titles managed in system admin page?)Enter job title</li>
    <li>Select authorization(s) and sub-authorization(s)</li>
    <li>(Optional) Add notes or comments</li>
    <li>(Optional, shown only if technical user is selected) Technical account note</li>
</ul>

#### <strike>New distribution list</strike>

System users can create a new distribution list.</br>
The form includes the following fields:
<ul>
    <li>Distribution list address – the email address of the list</li>
    <li>Distribution list members – users to be included in the list</li>
</ul>

#### <strike>Requests</strike>

<ul>
    <li><strike>Pending approvals</strike></li>
        <ul>
            <li>Approve, decline, or return the request to the submitter for missing details</li>
                <ul>
                    <li>Include a note explaining what's missing</li>
                </ul>
            <li>(Optional) Fill in usernames (if required)</li>
        </ul>
    <li><strike>Approved requests</strike></li> 
        <ul>
            <li>Fill in usernames (LDAP integration will auto-fill if enabled)</li>
            <li>Return to submitter for missing details</li>
                <ul>
                    <li>Include a note explaining what's missing</li>
                </ul>
            <li>Save changes</li>
            <li>Mark as completed — for new user requests, this will create the user based on the submitted data</li>
        </ul>
    <li><strike>All requests</strike></li>
        <ul>
            <li>Search and view all submitted requests</li>
        </ul>
</ul>

#### <strike>Users</strike>

<ul>
    <li>Search and view all users</li>
        <ul>
            <li>Submit an edit request - user details pre-filled</li>
            <li>Submit a delete request</li>
        </ul>
</ul>

#### <strike>Distribution lists</strike>

<ul>
    <li>Search and view all ditribution lists</li>
        <ul>
            <li>Edit a distribution list</li>
            <li>Delete a distribution list</li>
        </ul>
</ul>


#### Personal menu

<ul>
    <li>Profile</li>
        <ul>
            <li>Set your full name</li>
            <li>Set your notification e-mail</li>
        </ul>
    <li>System admin interface</li>
        <ul>
            <li>Navigate to the system admin page</li>
        </ul>
    <li>Log out</li>
</ul>

[Laravel-logo]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Livewire-logo]: https://img.shields.io/badge/livewire-%234e56a6.svg?style=for-the-badge&logo=livewire&logoColor=white
[Livewire-url]: https://livewire.laravel.com/
[Tailwindcss-logo]: https://img.shields.io/badge/Tailwind_CSS-grey?style=for-the-badge&logo=tailwind-css&logoColor=38B2AC
[Tailwindcss-url]: https://tailwindcss.com/
[MySQL-logo]: https://shields.io/badge/MySQL-lightgrey?logo=mysql&style=plastic&logoColor=white&labelColor=blue
[MySQL-url]: https://www.mysql.com/
