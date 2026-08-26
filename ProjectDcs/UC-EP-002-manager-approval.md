# UC-EP-002-manager-approval.md

**Module:** EP  
**Related:** BR-EP-001

## Actor
Manager / Supervisor

## Flow
1. Manager reviews draft entries (`?view=entry`, filter by `status=draft`).
2. Approves: updates `status=approved`. If rejected, notes added; employee edits and resubmits.
3. Approved entries locked for calculation; GL posting permitted (`gl_posted=1` after approval + posting).
