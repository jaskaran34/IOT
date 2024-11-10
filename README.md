# Project Name

## Overview
This project allows users to manage and monitor different types of modules, generate random module measurements, and simulate module failures.

## Features
- **Add Module Types**: Create and manage different types of modules such as temperature, pressure, speed, etc.
- **Add and Edit Modules**: Add new modules by specifying their name and type, and edit existing modules to update their name and status (active or inactive).
- **Generate Random Data**: Generate random module measurements with a background script.
- **Dashboard**: View accumulated data in an organized and user-friendly manner.
- **View Status**: Access detailed data, including historical measurements and graphical representations of module readings over time.
- **Simulate Module Failure**: Simulate a module failure with a background script and receive notifications about the simulation.

## Getting Started

### Prerequisites
- Ensure you have the necessary environment and dependencies installed (e.g., PHP, Laravel, etc.)

### Installation
1. Clone the repository:
    ```sh
    git clone https://github.com/yourusername/project-name.git
    cd project-name
    ```

2. Set up the environment:
    ```sh
    cp .env.example .env
    ```

3. Run migrations:
    ```sh
    php artisan migrate
    ```

4. Start the development server:
    ```sh
    php artisan serve
    ```

## Usage

### Adding Module Types
1. Navigate to the **Types** option on the sidebar.
2. Add new module types such as temperature, pressure, speed, etc.

### Adding and Editing Modules
1. Go to the **Modules** option on the sidebar.
2. Add new modules by naming them and selecting their type.
3. Edit existing modules to change their name and status (active or inactive).

### Generating Random Data
1. Select the **Generate Random Data** option on the sidebar.
2. Click the button to run a background script that generates random module measurements.

### Viewing Dashboard
1. Click on the **Dashboard** link on the sidebar.
2. View the accumulated data in a visually organized manner.

### Viewing Status
1. Choose the **Status** option on the sidebar.
2. Select an individual module to view its detailed data, including historical measurements and graphical data showing readings over time.

### Simulating Module Failure
1. Go to the **Generate Random Data** page.
2. Click the **Simulate Module Failure** button to run a background script that simulates a module failure.
3. Receive a notification about the simulated failure.
