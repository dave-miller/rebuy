# Setup

### Install homebrew
```
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

### Install ansible
```
brew install ansible
```

### Run ansible script
Ansible will install all brew packages neccessary to run Tilt.
```
sh ansible/install.sh
```

# Running App

### Run Tilt in CLI
```
tilt up
```
- To view tilt in the browser: http://localhost:10350/r/(all)/overview
- Once viewing, you will notice a pod labeled `testing-pomodoro`, this will trigger unit tests to run.  You must manually trigger this

### In optional terminal window
This will show you the pods running in real time, view logs, restart, etc, etc
```
k9s
```


# Config

### Env values
all env values are set in a helm values file.