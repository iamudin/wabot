import dotenv from "dotenv";
import path from "path";
const envPath = path.resolve(process.cwd(), ".env");
console.log("Looking for .env at:", envPath);
const result = dotenv.config({ path: envPath });
console.log("dotenv result:", result);
import { z } from "zod";

console.log("WEBHOOK_BASE_URL:", process.env.WEBHOOK_BASE_URL);

export const env = z
  .object({
    NODE_ENV: z.enum(["development", "production"]).default("development"),
    KEY: z.string().default(""),
    PORT: z
      .string()
      .default("5001")
      .transform((e) => Number(e)),
    WEBHOOK_BASE_URL: z.string().optional(),
  })
  .parse(process.env);
