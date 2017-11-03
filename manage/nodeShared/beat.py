import subprocess, time

if __name__ == '__main__':
    while True:
        subprocess.call(['php', 'supervisor.php'])
        time.sleep(60*5)
