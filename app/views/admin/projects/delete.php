<?php
adminGuard();

// Delete is handled by the process file
// This file just redirects back to projects
// if someone tries to access it directly

redirect('?page=admin-projects');