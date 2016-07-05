import subprocess, sys, os

args     = sys.argv
path_pid = args[1]
path_log = args[2]
daemon   = args[3]
success  = '%s/app_success.log' % path_log
error    = '%s/app_error.log'   % path_log
pid      = '%s/%s' % (path_pid, daemon)

try:
    os.remove(success)
    os.remove(error)
except OSError:
    pass

del args[:4]

proc = subprocess.Popen(args, 
                        stdout=file(success, 'ab'), 
                        stderr=file(error,   'ab'))

f = open(pid, 'w')
f.write(str(proc.pid))
f.close()
