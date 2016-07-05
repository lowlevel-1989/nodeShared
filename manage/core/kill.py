import os, sys, signal
PID = int(sys.argv[1])

try:
    os.kill(PID, signal.SIGTERM)
    print True
except OSError:
    print False
