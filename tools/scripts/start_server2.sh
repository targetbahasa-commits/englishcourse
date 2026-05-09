#!/bin/bash
python3 -m http.server 8002 > /dev/null 2>&1 &
echo $! > py_server.pid
echo "Python server started on port 8002"
