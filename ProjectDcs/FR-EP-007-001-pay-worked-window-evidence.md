# FR-EP-007-001 — Pay-run worked-window evidence from closed events (read-only)

@BABOK Related: BR-007; FR-HRM-007-001 (window view source);
          FR-CAL-007-002 (broadcast it consumes).
Status: Approved — BABOK; implementation parks next stage.
Module: ksf_FA_EmployeePay (read-only consumer; writes nothing via this flow).

## Need (BABOK What-not-How)
Pay runs may need to count hours worked at closed attendance events (meetings,
trainings, on-site work) as "worked-window evidence". EmployeePay must be able
to see those windows WITHOUT creating or mutating timesheet, expense, calendar,
or HRM records — evidence is a read view, not a write path.

## Requirement
1. Subscribes (optionally) to `ksf_event_closed`; for each attendee that is an
   active employee (classification membership per FR-CAL-007-003), the pay-run
   view can present the worked window `{employee, started_at, closed_at, qty,
   event_id, title}` from the DTO.
2. The module performs NO writes in this flow; all reads run through its own
   read path over the authoritative DTO (same canonical payload, no re-read of
   other tables).
3. Incoming duplicate broadcasts produce the same read view (nothing to dedupe —
   the view is derived).
4. Fault-tolerant: absence of the DTO/event simply yields an empty view segment,
   never an error that blocks a pay run.

## Acceptance
- ARI: a pay run over a closed-event window sees exactly the N member windows
  for that event.
- AZZ: attendee not an employee -> excluded from the evidence view.
- BON: no broadcast/event -> empty segment, pay run completes.