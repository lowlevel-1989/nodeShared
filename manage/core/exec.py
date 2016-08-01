import subprocess, sys, os

args        = sys.argv
path_pid    = args[1]
path_log    = args[2]
daemon      = args[3]
envs        = args[4][1:len(args[4])-1]
success     = '%s/app_success.log' % path_log
error       = '%s/app_error.log'   % path_log
pid         = '%s/%s' % (path_pid, daemon)

environment = {}
envs = envs.split(',')

def setEnv(i, x):
    if i > 0:
        return ':%s' % x
    else:
        return str(x)

for key, value in enumerate(envs):
    value = value.split(':')
    if len(value) >= 2:
        name = value[0]
        del value[0]
        environment[name] = ''.join(setEnv(i, x) for i, x in enumerate(value))

try:
    os.remove(success)
    os.remove(error)
except OSError:
    pass

del args[:5]

proc = subprocess.Popen(args, env=environment,
                        stdout=file(success, 'ab'), 
                        stderr=file(error,   'ab'))

f = open(pid, 'w')
f.write(str(proc.pid))
f.close()
