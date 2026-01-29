import { Router } from "express";
import { register, login, getRanking } from "../controllers/userController.js";

const router = Router();

router.post('/register', register);
router.post('/login', login);
router.get('/ranking', getRanking);

export default router;