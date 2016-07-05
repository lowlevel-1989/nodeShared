import sys, os
PID = int(sys.argv[1])

try:
    os.kill(PID, 0)
    print True
except OSError:
    print False
