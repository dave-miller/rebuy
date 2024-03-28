load('ext://dotenv', 'dotenv')
allow_k8s_contexts('docker-desktop')
docker_prune_settings(False, max_age_mins=360, interval_hrs=1, keep_recent=1 )
update_settings(max_parallel_updates=1)

# DB POD
docker_build(
    ref='mariadb-dev',
    context='.',
    dockerfile='./docker/mariadb/Dockerfile',
    only=[
        'docker',
        'kubernetes'
    ]
)
k8s_yaml(helm('kubernetes/mariadb', name='mariadb'))
k8s_resource("mariadb", labels=["data"],
        port_forwards=[
        '8306:3306'
    ]
)


# APP POD
docker_build(
    ref='pomodoro',
    context='.',
    dockerfile='./docker/app/Dockerfile',
    only=[
        'docker',
        'kubernetes'
    ]
)
k8s_yaml(helm('kubernetes/pomodoro', name='pomodoro'))
k8s_resource("pomodoro", 
    labels=["backend"], 
    pod_readiness='wait',
    port_forwards=[
        '8000:8000'
    ]
)

k8s_resource("testing-pomodoro",
    labels=["testing"],
    resource_deps=['pomodoro'],
    auto_init=False,
    trigger_mode=TRIGGER_MODE_MANUAL)


# NGINX POD
# docker_build(
#     ref='nginx-dev',
#     context='.',
#     dockerfile='./docker/nginx/Dockerfile',
#     only=[
#         'docker',
#         'kubernetes'
#     ])

# k8s_yaml(helm('kubernetes/nginx', name='nginx'))
# k8s_resource("nginx",labels=["backend"],
# port_forwards=[
#     '8080:88'
# ])


watch_settings([
    '/docker/**/*',
    '/kubernetes/**/*'
    # '!/node_modules/**/*',
    # '!/vendor/**/*',
    # '!/storage/**/*'
])