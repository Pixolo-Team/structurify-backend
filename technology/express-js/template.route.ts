// MODULES //
import { Router } from "express";

// CONTROLLERS //
import * as |PascalCase|Controller from "../controllers/|kebab-case|";

// Define Router
const router = Router();

// GET - Get |PascalCase|
router.get("/", |PascalCase|Controller.get|PascalCase|);

export default router;
