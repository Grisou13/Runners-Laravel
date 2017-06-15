# Workflow behind creating runs

Runs are created first by attacking POST /runs
That creates a temporary run, which has a drafted=true and status=drafting
The only fields required to create the run, are:
- name
- nb_place

This is really basic, and allows coordinators to be swift and create on the fly runs

Then to publish the run you need to call POST /runs/{runId}/publish
You can pass fields to finish the run.

The run can be published __ONLY IF__:
- name is defined
- planned_at is defined
- nb_passenger is defined
- runners has atleast one car type, or car defined
- has atleast 2 waypoints
