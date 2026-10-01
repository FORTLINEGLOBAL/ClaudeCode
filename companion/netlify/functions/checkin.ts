// Scheduled every 15 minutes (netlify.toml). Scheduled functions get 30 seconds,
// so the check-ins themselves run in the background worker.
import { dispatch } from "../../src/internal.js";

export default async () => {
  await dispatch({ kind: "checkins" });
};
