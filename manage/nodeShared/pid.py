import sys, os

def exist_pid(PID):
    try:
        os.kill(PID, 0)
        print True
    except OSError:
        print False

if __name__ == '__main__':
    PID = int(sys.argv[1])
    exist_pid(PID)
