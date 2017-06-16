# Workflow behind creating runs

Runs are created first by attacking POST /runs
That creates a temporary run, which has a drafted=true and status=drafting
The only fields required to create the run, are:
- name
- nb_place

This is really basic, and allows coordinators to be swift and create runs on the fly.
The runs create when created by POST /runs are __always drafting__.

Then to publish the run you need to call POST /runs/{runId}/publish
You can pass fields to finish the run.

The run can be published __ONLY IF__:
- name is defined
- planned_at is defined
- nb_passenger is defined
- runners has atleast one car type, or car defined
- has atleast 2 waypoints

# Run list

The run list is a bit tricky. It's a react-redux app.
Here's why:
- No need to bind the dom and data
- Easy to create complexe ui without binding values back and forth

The entry file is `/assets/js/runs/app.js`

The file is compiled to `/public/js/runs.js`
