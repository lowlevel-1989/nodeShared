import os, sys, signal

def p_kill(PID):
    try:
        os.kill(PID, signal.SIGTERM)
        print True
    except OSError:
        print False

if __name__ == '__main__':
    PID = int(sys.argv[1])
    p_kill(PID)
