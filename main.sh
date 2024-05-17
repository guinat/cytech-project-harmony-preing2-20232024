# Check if port 8000 is not already in use
if ! lsof -i :8000 >/dev/null 2>&1; then
    # If not in use, start a PHP server on localhost:8000 in the background
    php -S localhost:8000 &
fi

# Wait for 1 second before opening the web page
sleep 1

# Open the index.php page in the default web browser
xdg-open http://localhost:8000/index.php >/dev/null 2>&1 &
