# Workflow behind creating runs

Runs are created first by attacking POST /runs
That creates a temporary run, which has a drafted=true and status=drafting

Then to publish the run you need to call POST /runs/{runId}/publish
You can pass fields to finish the run. The run can be published if:
- name is defined
- planned_at is defined
- nb_passenger is defined
- runners has atleast one car type, or car defined
- has atleast 2 waypoints

