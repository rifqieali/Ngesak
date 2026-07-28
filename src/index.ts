import { Elysia, t } from "elysia";
import { db } from "./db";
import { users } from "./db/schema";

const port = Number(process.env.PORT) || 3000;

const app = new Elysia()
  .decorate("db", db)
  .get("/", () => ({ status: "ok", message: "Server is running!" }))
  .get("/users", async ({ db }) => {
    return await db.select().from(users);
  })
  .post(
    "/users",
    async ({ db, body }) => {
      const newUser = await db.insert(users).values(body).returning();
      return newUser[0];
    },
    {
      body: t.Object({
        name: t.String(),
        email: t.String({ format: "email" }),
      }),
    }
  )
  .listen(port);

console.log(`🚀 Elysia server is running at http://${app.server?.hostname}:${app.server?.port}`);

export type App = typeof app;
