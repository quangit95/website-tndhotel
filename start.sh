#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
cd "$DIR"

# Thêm đường dẫn PHP vào PATH
export PATH="$HOME/.local/php:$HOME/.local/node/bin:$PATH"

echo "🚀 Đang khởi động website TND Hotel..."
echo "🌐 Truy cập tại: http://localhost:8000"

# Mở trình duyệt
open http://localhost:8000

# Chạy PHP Server
php -S 0.0.0.0:8000 router.php
