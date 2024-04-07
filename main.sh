if ! lsof -i :8000 >/dev/null 2>&1; then
    php -S localhost:8000 &
fi

sleep 1

xdg-open http://localhost:8000/index.php >/dev/null 2>&1 &
